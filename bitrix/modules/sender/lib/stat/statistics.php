<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sender
 * @copyright 2001-2012 Bitrix
 */
namespace Bitrix\Sender\Stat;

use Bitrix\Main\Context;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Type\Date;
use Bitrix\Main\UserTable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sender\MailingChainTable;
use Bitrix\Sender\PostingTable;
use Bitrix\Sender\PostingClickTable;
use Bitrix\Sender\PostingReadTable;
use Bitrix\Sender\MailingSubscriptionTable;

Loc::loadMessages(__FILE__);

class Statistics
{
	CONST AVERAGE_EFFICIENCY = 0.15;

	/** @var Filter */
	protected $filter;

	/** @var integer */
	protected $cacheTtl = 0;

	/**
	 * Create instance
	 * @param $filter Filter Filter
	 * @return static
	 */
	public static function create(Filter $filter = null)
	{
		return new static($filter);
	}

	public function __construct(Filter $filter = null)
	{
		if ($filter)
		{
			$this->filter = $filter;
		}
		else
		{
			$this->filter = new Filter();
		}

	}

	/**
	 * Set cache TTL
	 * @param integer $cacheTtl
	 * @return $this
	 */
	public function setCacheTtl($cacheTtl)
	{
		$this->cacheTtl = $cacheTtl;
		return $this;
	}

	/**
	 * Get cache TTL
	 * @return integer
	 */
	public function getCacheTtl()
	{
		return $this->cacheTtl;
	}

	/**
	 * Return filter
	 *
	 * @return Filter
	 */
	public function getFilter()
	{
		return $this->filter;
	}

	/**
	 * Return filter
	 * @param $name string Filter name
	 * @param $value string Filter value
	 * @return $this
	 */
	public function filter($name, $value = null)
	{
		$this->filter->set($name, $value);
		return $this;
	}

	public function initFilterFromRequest()
	{
		$request = Context::getCurrent()->getRequest();
		$list = $this->filter->getNames();
		foreach ($list as $name)
		{
			$this->filter->set($name, (string) $request->get($name));
		}

		if (!$this->filter->get('period'))
		{
			$this->filter->set('period', Filter::PERIOD_MONTH);
		}

		return $this;
	}

	protected static function calculateEfficiency($counters, $maxEfficiency = null)
	{
		$efficiency = self::div('CLICK', 'READ', $counters);
		if (!$maxEfficiency)
		{
			$maxEfficiency = self::AVERAGE_EFFICIENCY * 2;
		}
		$efficiency = $efficiency > $maxEfficiency ? $maxEfficiency : $efficiency;
		return self::getCounterCalculation('EFFICIENCY', $efficiency, $maxEfficiency);
	}

	protected static function div($dividendCode, $dividerCode, $items)
	{
		$divider = 0;
		foreach ($items as $item)
		{
			if ($item['CODE'] == $dividerCode)
			{
				$divider = (float) $item['VALUE'];
				break;
			}
		}

		if ($divider == 0)
		{
			return 0;
		}

		$dividend = 0;
		foreach ($items as $item)
		{
			if ($item['CODE'] == $dividendCode)
			{
				$dividend = (float) $item['VALUE'];
				$dividend = $dividend > $divider ? $divider : $dividend;
				break;
			}
		}

		return $dividend / $divider;
	}

	protected static function formatNumber($number, $num = 1)
	{
		$formatted = number_format($number, $num, '.', ' ');
		$formatted = substr($formatted, -($num + 1)) == '.' . str_repeat('0', $num) ? substr($formatted, 0, -2) : $formatted;
		return $formatted;
	}

	protected static function getCounterCalculation($code, $value, $percentBase = 0)
	{
		$value = (float) $value;
		$percentValue = $percentBase > 0 ? $value / $percentBase : 0;

		return array(
			'CODE' => $code,
			'VALUE' => round($value, 2),
			'VALUE_DISPLAY' => self::formatNumber($value, 0),
			'PERCENT_VALUE' => round($percentValue, $code == 'UNSUB' ? 3 : 2),
			'PERCENT_VALUE_DISPLAY' => self::formatNumber($percentValue * 100, $code == 'UNSUB' ? 1 : 0),
		);
	}

	protected function getMappedFilter()
	{
		$filter = array(
			'!STATUS' => PostingTable::STATUS_NEW,
		);

		$fieldsMap = array(
			'chainId' => '=MAILING_CHAIN_ID',
			'periodFrom' => '>DATE_SENT',
			'periodTo' => '<DATE_SENT',
			'mailingId' => '=MAILING_ID',
			'postingId' => '=ID',
			'authorId' => '=MAILING_CHAIN.CREATED_BY',
		);
		return $this->filter->getMappedArray($fieldsMap, $filter);
	}

	/**
	 * Return efficiency
	 *
	 * @return float
	 */
	public function getEfficiency()
	{
		return self::calculateEfficiency($this->getCounters());
	}

	/**
	 * Return dynamic of counters
	 * @return array
	 */
	public function getCountersDynamic()
	{
		$list = array();
		$filter = $this->getMappedFilter();
		$select = array(
			'SEND_ALL' => 'COUNT_SEND_ALL',
			'SEND_ERROR' => 'COUNT_SEND_ERROR',
			'SEND_SUCCESS' => 'COUNT_SEND_SUCCESS',
			'READ' => 'COUNT_READ',
			'CLICK' => 'COUNT_CLICK',
			'UNSUB' => 'COUNT_UNSUB'
		);
		$runtime = array(
			new ExpressionField('CNT', 'COUNT(%s)', 'ID'),
			new ExpressionField('DATE', 'DATE(%s)', 'DATE_SENT'),
		);
		foreach ($select as $alias => $fieldName)
		{
			$runtime[] = new ExpressionField($alias, 'SUM(%s)', $fieldName);
		}
		$select = array_keys($select);
		$select[] = 'DATE';
		$select[] = 'CNT';
		$listDb = PostingTable::getList(array(
			'select' => $select,
			'filter' => $filter,
			'runtime' => $runtime,
			'order' => array('DATE' => 'ASC'),
			'cache' => array('ttl' => $this->getCacheTtl(), 'cache_joins' => true)
		));
		while($item = $listDb->fetch())
		{
			$date = null;
			foreach ($item as $name => $value)
			{
				if (!in_array($name, array('DATE')))
				{
					continue;
				}

				if ($item['DATE'])
				{
					/** @var Date $date */
					$date = $item['DATE']->getTimestamp();
				}
			}

			$counters = array();
			foreach ($item as $name => $value)
			{
				if (!in_array($name, array('READ', 'CLICK', 'UNSUB')))
				{
					continue;
				}
				else
				{
					$base = $item['SEND_SUCCESS'];
				}

				$counter = self::getCounterCalculation($name, $value, $base);
				$counter['DATE'] = $date;
				$counters[] = $counter;
				$list[$name][] = $counter;
			}

			$effCounter = self::calculateEfficiency($counters, 1);
			$effCounter['DATE'] = $date;
			$list['EFFICIENCY'][] = $effCounter;
		}

		return $list;

	}

	/**
	 * Return counters
	 * @return array
	 */
	public function getCounters()
	{
		$list = array();
		$filter = $this->getMappedFilter();
		$select = array(
			'SEND_ALL' => 'COUNT_SEND_ALL',
			'SEND_ERROR' => 'COUNT_SEND_ERROR',
			'SEND_SUCCESS' => 'COUNT_SEND_SUCCESS',
			'READ' => 'COUNT_READ',
			'CLICK' => 'COUNT_CLICK',
			'UNSUB' => 'COUNT_UNSUB'
		);
		$runtime = array();
		foreach ($select as $alias => $fieldName)
		{
			$runtime[] = new ExpressionField($alias, 'SUM(%s)', $fieldName);
		}
		$listDb = PostingTable::getList(array(
			'select' => array_keys($select),
			'filter' => $filter,
			'runtime' => $runtime,
			'cache' => array('ttl' => $this->getCacheTtl(), 'cache_joins' => true)
		));
		while ($item = $listDb->fetch())
		{
			foreach ($item as $name => $value)
			{
				if (substr($name, 0, 4) == 'SEND')
				{
					$base = $item['SEND_ALL'];
				}
				else
				{
					$base = $item['SEND_SUCCESS'];
				}
				$list[] = self::getCounterCalculation($name, $value, $base);
			}
		}

		return $list;
	}

	/**
	 * Return subscribers
	 * @return array
	 */
	public function getCounterPostings()
	{
		$query = PostingTable::query();
		$query->addSelect(new ExpressionField('CNT', 'COUNT(1)'));
		$query->setFilter($this->getMappedFilter());
		$query->setCacheTtl($this->getCacheTtl());
		$query->cacheJoins(true);
		$result = $query->exec()->fetch();

		return self::getCounterCalculation('POSTINGS', $result['CNT']);
	}

	/**
	 * Return subscribers
	 * @return array
	 */
	public function getCounterSubscribers()
	{
		$filter = array('=IS_UNSUB' => 'N');
		$map = array(
			'mailingId' => '=MAILING_ID',
			'periodFrom' => '>DATE_INSERT',
			'periodTo' => '<DATE_INSERT',
		);
		$filter = $this->filter->getMappedArray($map, $filter);

		$query = MailingSubscriptionTable::query();
		$query->addSelect(new ExpressionField('CNT', 'COUNT(1)'));
		$query->setFilter($filter);
		$query->setCacheTtl($this->getCacheTtl());
		$query->cacheJoins(true);
		$result = $query->exec()->fetch();

		return self::getCounterCalculation('SUBS', $result['CNT']);
	}

	/**
	 * Return click links
	 * @param $limit integer Limit
	 * @return array
	 */
	public function getClickLinks($limit = 15)
	{
		$list = array();
		$clickDb = PostingClickTable::getList(array(
			'select' => array('URL', 'CNT'),
			'filter' => array(
				'=POSTING_ID' => $this->filter->get('postingId'),
			),
			'runtime' => array(
				new ExpressionField('CNT', 'COUNT(%s)', 'ID'),
			),
			'group' => array('URL'),
			'order' => array('CNT' => 'DESC'),
			'limit' => $limit
		));
		while($click = $clickDb->fetch())
		{
			$list[] = $click;
		}

		return $list;
	}

	/**
	 * Return read counter data by day time
	 * @param int $step Step
	 * @return array
	 */
	public function getReadingByDayTime($step = 2)
	{
		$list = array();
		for ($i = 0; $i < 24; $i++)
		{
			$list[$i] = array(
				'CNT' => 0,
				'CNT_DISPLAY' => 0,
				'DAY_HOUR' => $i,
				'DAY_HOUR_DISPLAY' => (strlen($i) == 1 ? '0' : '') . $i . ':00',
			);
		}

		$filter = $this->getMappedFilter();
		$readDb = PostingTable::getList(array(
			'select' => array('DAY_HOUR', 'CNT'),
			'filter' => $filter,
			'runtime' => array(
				new ExpressionField('CNT', 'COUNT(%s)', 'POSTING_READ.ID'),
				new ExpressionField('DAY_HOUR', 'HOUR(%s)', 'POSTING_READ.DATE_INSERT'),
			),
			'order' => array('DAY_HOUR' => 'ASC'),
		));
		while($read = $readDb->fetch())
		{
			$read['DAY_HOUR'] = intval($read['DAY_HOUR']);
			if (array_key_exists($read['DAY_HOUR'], $list))
			{
				$list[$read['DAY_HOUR']]['CNT'] = $read['CNT'];
				$list[$read['DAY_HOUR']]['CNT_DISPLAY'] = self::formatNumber($read['CNT'], 0);
			}
		}

		if ($step > 1)
		{
			for ($i = 0; $i < 24; $i+=$step)
			{
				for ($j = 1; $j < $step; $j++)
				{
					$list[$i]['CNT'] += $list[$i + $j]['CNT'];
					unset($list[$i + $j]);
				}
				$list[$i]['CNT_DISPLAY'] = self::formatNumber($list[$i]['CNT'], 0);
			}
		}

		$list = array_values($list);

		return $list;
	}

	/**
	 * Return recommended sending time for mailing

	 * @return string
	 */
	public function getRecommendedSendTime($chainId = null)
	{
		$timeList = $this->getReadingByDayTime(1);
		$len = count($timeList);
		$weightList = array();
		for ($i = 0; $i <= $len; $i++)
		{
			$j = $i + 1;
			if ($j > $len)
			{
				$j = 0;
			}
			else if ($j < 0)
			{
				$j = 23;
			}
			$weight = $timeList[$i]['CNT'] + $timeList[$j]['CNT'];
			$weightList[$i] = $weight;
		}

		$deliveryTime = 0;
		if ($chainId)
		{
			$listDb = PostingTable::getList(array(
				'select' => array('COUNT_SEND_ALL'),
				'filter' => array(
					'=MAILING_CHAIN_ID' => $chainId
				),
				'order' => array('DATE_CREATE' => 'DESC'),
			));
			if ($item = $listDb->fetch())
			{
				$deliveryTime = intval($item['COUNT_SEND_ALL']  * 1/10 * 1/3600);
			}
		}
		if ($deliveryTime <= 0)
		{
			$deliveryTime = 1;
		}

		arsort($weightList);
		foreach ($weightList as $i => $weight)
		{
			$i -= $deliveryTime;
			if ($i >= $len)
			{
				$i = $i - $len;
			}
			else if ($i < 0)
			{
				$i = $len + $i;
			}
			$timeList[$i]['DELIVERY_TIME'] = $deliveryTime;
			return $timeList[$i];
		}

		return null;
	}

	/**
	 * Return chain list
	 * @param $limit integer Limit
	 * @return array
	 */
	public function getChainList($limit = 20)
	{
		$filter = $this->getMappedFilter();
		$listDb = PostingTable::getList(array(
			'select' => array(
				'DATE_SENT',
				'CHAIN_ID' => 'MAILING_CHAIN_ID',
				'TITLE' => 'MAILING_CHAIN.TITLE',
				'SUBJECT' => 'MAILING_CHAIN.SUBJECT',
				'MAILING_ID',
				'MAILING_NAME' => 'MAILING.NAME',
			),
			'filter' => $filter,
			'order' => array('DATE_SENT' => 'DESC'),
			'limit' => $limit,
			'cache' => array('ttl' => $this->getCacheTtl(), 'cache_joins' => true)
		));
		$list = array();
		while ($item = $listDb->fetch())
		{
			$dateSentFormatted = '';
			if ($item['DATE_SENT'])
			{
				$dateSentFormatted = \FormatDate('x', $item['DATE_SENT']->getTimestamp());
			}

			$list[] = array(
				'ID' => $item['CHAIN_ID'],
				'NAME' => $item['TITLE'] ? $item['TITLE'] : $item['SUBJECT'],
				'MAILING_ID' => $item['MAILING_ID'],
				'MAILING_NAME' => $item['MAILING_NAME'],
				'DATE_SENT' => (string) $item['DATE_SENT'],
				'DATE_SENT_FORMATTED' => $dateSentFormatted,
			);
		}
		return $list;
	}

	/**
	 * Return global filter data
	 *
	 * @return array
	 */
	public function getGlobalFilterData()
	{
		$period = $this->getFilter()->get('period');

		return array(
			array(
				'name' => 'authorId',
				'value' => $this->getFilter()->get('authorId'),
				'list' => $this->getAuthorList(),
			),
			array(
				'name' => 'period',
				'value' => $period ? $period : Filter::PERIOD_MONTH,
				'list' => $this->getPeriodList(),
			)
		);
	}

	/**
	 * Return period list
	 *
	 * @return array
	 */
	protected function getPeriodList()
	{
		$list = array(
			Filter::PERIOD_WEEK,
			Filter::PERIOD_MONTH,
			Filter::PERIOD_MONTH_3,
			Filter::PERIOD_MONTH_6,
			Filter::PERIOD_MONTH_12
		);

		$result = array();
		foreach ($list as $period)
		{
			$result[] = array(
				'ID' => $period,
				'NAME' => Loc::getMessage('SENDER_STAT_STATISTICS_FILTER_PERIOD_' . $period)
			);
		}

		return $result;
	}

	/**
	 * Return author list
	 *
	 * @return array
	 */
	protected function getAuthorList()
	{
		$listDb = MailingChainTable::getList(array(
			'select' => array('CREATED_BY'),
			'group' => array('CREATED_BY'),
			'limit' => 20,
			'cache' => array('ttl' => $this->getCacheTtl(), 'cache_joins' => true)
		));
		$userList = array();
		while ($item = $listDb->fetch())
		{
			if (!$item['CREATED_BY'])
			{
				continue;
			}

			$userList[] = $item['CREATED_BY'];
		}

		$list = array();
		$list[] = array(
			'ID' => 'all',
			'NAME' => Loc::getMessage('SENDER_STAT_STATISTICS_FILTER_AUTHOR_FROM_ALL')
		);

		/** @var CUser */
		global $USER;
		if (is_object($USER) && $USER->getID())
		{
			$list[] = array(
				'ID' => $USER->getID(),
				'NAME' => Loc::getMessage('SENDER_STAT_STATISTICS_FILTER_AUTHOR_FROM_ME')
			);
		}

		$listDb = UserTable::getList(array(
			'select' => array(
				'ID',
				'TITLE',
				'NAME',
				'SECOND_NAME',
				'LAST_NAME',
				'LOGIN',
			),
			'filter' => array('=ID' => $userList),
			'order' => array('NAME' => 'ASC')
		));
		while ($item = $listDb->fetch())
		{
			$name = \CUser::formatName(\CSite::getNameFormat(true), $item, true, true);
			$list[] = array(
				'ID' => $item['ID'],
				'NAME' => $name,
			);
		}

		return $list;
	}
}
