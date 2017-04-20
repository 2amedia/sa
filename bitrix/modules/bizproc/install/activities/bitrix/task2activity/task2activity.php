<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class CBPTask2Activity
	extends CBPActivity
{
	public function __construct($name)
	{
		parent::__construct($name);
		$this->arProperties = array(
			"Title" => "", 
			"TaskGroupId" => "", 
			"TaskOwnerId" => "", //
			"TaskCreatedBy" => "", //
			"TaskActiveFrom" => "", //
			"TaskActiveTo" => "", //
			"TaskName" => "", //
			"TaskDetailText" => "", //
			"TaskPriority" => "", //
			"TaskAssignedTo" => "", //
			"TaskTrackers" => "", //
                        "TaskCheckResult" => "", //
			"TaskReport" => "", //
                        "TaskChangeDeadline" => "",
		);
	}

	private function __GetUsers($arUsersDraft)
	{
            
		$arUsers = array();

		$rootActivity = $this->GetRootActivity();
		$documentId = $rootActivity->GetDocumentId();

		$documentService = $this->workflow->GetService("DocumentService");

		$arUsersDraft = (is_array($arUsersDraft) ? $arUsersDraft : array($arUsersDraft));
		$l = strlen("user_");
		foreach ($arUsersDraft as $user)
		{
			if (substr($user, 0, $l) == "user_")
			{
				$user = intval(substr($user, $l));
				if ($user > 0)
					$arUsers[] = $user;
			}
			else
			{
				$arDSUsers = $documentService->GetUsersFromUserGroup($user, $documentId);
				foreach ($arDSUsers as $v)
				{
					$user = intval($v);
					if ($user > 0)
						$arUsers[] = $user;
				}
			}
		}

		return $arUsers;
	}

	public function Execute()
	{

		if (!CModule::IncludeModule("tasks"))
			return CBPActivityExecutionStatus::Closed;
              
		$arTaskCreatedBy = $this->__GetUsers($this->TaskCreatedBy);
		$arTaskAssignedTo = $this->__GetUsers($this->TaskAssignedTo);

		if (count($arTaskCreatedBy) <= 0 || count($arTaskAssignedTo) <= 0)
			return CBPActivityExecutionStatus::Closed;

		$arTaskTrackers = $this->__GetUsers($this->TaskTrackers);

                $bFirst = true;
                $ACCOMPLICES = array();
                foreach($arTaskAssignedTo as $respUser)
                {
                    if ($bFirst)
                    {
                        $RESPONSIBLE_ID = $respUser;
                        $bFirst = false;
                    }
                    else
                        $ACCOMPLICES[] = $respUser;
                }

		$arFields = array(
			"MODIFIED_BY" => $arTaskCreatedBy[0],
			"CREATED_BY" => $arTaskCreatedBy[0],
                        "SITE_ID" => SITE_ID,
                        "STATUS" => "1",
			"DATE_CREATE" => date($GLOBALS["DB"]->DateFormatToPHP(FORMAT_DATETIME)),
			"START_DATE_PLAN" => $this->TaskActiveFrom,
			"END_DATE_PLAN" => $this->TaskActiveTo,
                        "DEADLINE" => $this->TaskActiveTo,
			"TITLE" => $this->TaskName,
			"DESCRIPTION" => $this->TaskDetailText,
			"PRIORITY" => $this->TaskPriority,
			"RESPONSIBLE_ID" => $RESPONSIBLE_ID,
			"AUDITORS" => $arTaskTrackers,
                        "ADD_IN_REPORT" => $this->TaskReport,
                        "TASK_CONTROL" => $this->TaskCheckResult,
                        "ALLOW_CHANGE_DEADLINE" => $this->TaskChangeDeadline,
		);
                if ($this->TaskGroupId && $this->TaskGroupId !== 0)
                      $arFields["GROUP_ID"] = $this->TaskGroupId;

                if (count ($ACCOMPLICES) > 0)
                    $arFields["ACCOMPLICES"] = $ACCOMPLICES;

                $task = new CTasks;
                $result = $task->Add($arFields);

                if ($result)
                    $this->WriteToTrackingService(str_replace("#VAL#", $result, GetMessage("BPSA_TRACK_OK")));

                $arErrors = $task->GetErrors();
                if (count($arErrors) > 0)
                    $this->WriteToTrackingService(GetMessage("BPSA_TRACK_ERROR"));
                
		return CBPActivityExecutionStatus::Closed;
	}

	public static function ValidateProperties($arTestProperties = array(), CBPWorkflowTemplateUser $user = null)
	{
		$arErrors = array();

		if (!array_key_exists("TaskAssignedTo", $arTestProperties) || count($arTestProperties["TaskAssignedTo"]) <= 0)
			$arErrors[] = array("code" => "NotExist", "parameter" => "TaskAssignedTo", "message" => GetMessage("BPSNMA_EMPTY_TASKASSIGNEDTO"));
		if (!array_key_exists("TaskName", $arTestProperties) || count($arTestProperties["TaskName"]) <= 0)
			$arErrors[] = array("code" => "NotExist", "parameter" => "TaskName", "message" => GetMessage("BPSNMA_EMPTY_TASKNAME"));

		return array_merge($arErrors, parent::ValidateProperties($arTestProperties, $user));
	}

	public static function GetPropertiesDialog($documentType, $activityName, $arWorkflowTemplate, $arWorkflowParameters, $arWorkflowVariables, $arCurrentValues = null, $formName = "")
	{
		$runtime = CBPRuntime::GetRuntime();

		if (!CModule::IncludeModule("socialnetwork"))
			return;

		$arMap = array(
			"TaskGroupId" => "task_group_id",
			"TaskOwnerId" => "task_owner_id",
			"TaskCreatedBy" => "task_created_by",
			"TaskActiveFrom" => "task_active_from",
			"TaskActiveTo" => "task_active_to",
			"TaskName" => "task_name",
			"TaskDetailText" => "task_detail_text",
			"TaskPriority" => "task_priority",
			"TaskAssignedTo" => "task_assigned_to",
			"TaskTrackers" => "task_trackers",
                        "TaskCheckResult" => "task_check_result",
                        "TaskReport" => "task_report",
                        "TaskChangeDeadline" => "task_change_deadline",
		);

		if (!is_array($arWorkflowParameters))
			$arWorkflowParameters = array();
		if (!is_array($arWorkflowVariables))
			$arWorkflowVariables = array();

		if (!is_array($arCurrentValues))
		{
			$arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName($arWorkflowTemplate, $activityName);
			if (is_array($arCurrentActivity["Properties"]))
			{
				foreach ($arMap as $k => $v)
				{
					if (array_key_exists($k, $arCurrentActivity["Properties"]))
					{
						if ($k == "TaskCreatedBy" || $k == "TaskAssignedTo" || $k == "TaskTrackers")
							$arCurrentValues[$arMap[$k]] = CBPHelper::UsersArrayToString($arCurrentActivity["Properties"][$k], $arWorkflowTemplate, $documentType);
                                                else
							$arCurrentValues[$arMap[$k]] = $arCurrentActivity["Properties"][$k];
					}
                                        elseif ($k == "TaskPriority")
                                        {
                                            $arCurrentValues[$arMap[$k]] = "1";
                                        }
					else
					{
                                            $arCurrentValues[$arMap[$k]] = "";
					}
				}
			}
			else
			{
				foreach ($arMap as $k => $v)
					$arCurrentValues[$arMap[$k]] = "";
			}

		}


                $arGroups = array(GetMessage("TASK_EMPTY_GROUP"));
		$db = CSocNetGroup::GetList(array("NAME" => "ASC"), array("ACTIVE" => "Y"), false, false, array("ID", "NAME"));
		while ($ar = $db->GetNext())
			$arGroups[$ar["ID"]] = "[".$ar["ID"]."]".$ar["NAME"];

		$arTaskPriority = array(0, 1, 2);
		foreach($arTaskPriority as $k => $v)
			$arTaskPriority[$v] = GetMessage("TASK_PRIORITY_".$v);

		return $runtime->ExecuteResourceFile(
			__FILE__,
			"properties_dialog.php",
			array(
				"arCurrentValues" => $arCurrentValues,
				"formName" => $formName,
				"arGroups" => $arGroups,
				"arTaskPriority" => $arTaskPriority,
			)
		);
	}

	public static function GetPropertiesDialogValues($documentType, $activityName, &$arWorkflowTemplate, &$arWorkflowParameters, &$arWorkflowVariables, $arCurrentValues, &$arErrors)
	{
		$arErrors = array();

		$runtime = CBPRuntime::GetRuntime();

		$arMap = array(
			"task_group_id" => "TaskGroupId",
			"task_owner_id" => "TaskOwnerId",
			"task_created_by" => "TaskCreatedBy",
			"task_active_from" => "TaskActiveFrom",
			"task_active_to" => "TaskActiveTo",
			"task_name" => "TaskName",
			"task_detail_text" => "TaskDetailText",
			"task_priority" => "TaskPriority",
			"task_assigned_to" => "TaskAssignedTo",
			"task_trackers" => "TaskTrackers",
			"task_forum_id" => "TaskForumId",
                        "task_check_result" => "TaskCheckResult",
                        "task_report" => "TaskReport",
                        "task_change_deadline" => "TaskChangeDeadline",
		);

		$arProperties = array();
		foreach ($arMap as $key => $value)
		{
			if ($key == "task_created_by" || $key == "task_assigned_to" || $key == "task_trackers")
				continue;
			$arProperties[$value] = $arCurrentValues[$key];
		}

		$arProperties["TaskCreatedBy"] = CBPHelper::UsersStringToArray($arCurrentValues["task_created_by"], $documentType, $arErrors);
		if (count($arErrors) > 0)
			return false;

		$arProperties["TaskAssignedTo"] = CBPHelper::UsersStringToArray($arCurrentValues["task_assigned_to"], $documentType, $arErrors);
		if (count($arErrors) > 0)
			return false;

		$arProperties["TaskTrackers"] = CBPHelper::UsersStringToArray($arCurrentValues["task_trackers"], $documentType, $arErrors);
		if (count($arErrors) > 0)
			return false;

		$arErrors = self::ValidateProperties($arProperties, new CBPWorkflowTemplateUser(CBPWorkflowTemplateUser::CurrentUser));
		if (count($arErrors) > 0)
			return false;

		$arCurrentActivity = &CBPWorkflowTemplateLoader::FindActivityByName($arWorkflowTemplate, $activityName);
		$arCurrentActivity["Properties"] = $arProperties;

		return true;
	}
}
?>