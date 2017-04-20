<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<tr>
	<td align="right" width="40%"><span style="color:#FF0000;">*</span> <?= GetMessage("BPTA1A_TASKNAME") ?>:</td>
	<td width="60%">
		<input type="text" name="task_name" id="id_task_name" value="<?= htmlspecialchars($arCurrentValues["task_name"]) ?>" size="50">
		<input type="button" value="..." onclick="BPAShowSelector('id_task_name', 'string');">
	</td>
</tr>
<tr>
	<td align="right" width="40%"><span style="color:#FF0000;">*</span> <?= GetMessage("BPTA1A_TASKCREATEDBY") ?>:</td>
	<td width="60%">
		<input type="text" name="task_created_by" id="id_task_created_by" value="<?= htmlspecialchars($arCurrentValues["task_created_by"]) ?>" size="50">
		<input type="button" value="..." onclick="BPAShowSelector('id_task_created_by', 'user');">
	</td>
</tr>
<tr>
	<td align="right" width="40%"><span style="color:#FF0000;">*</span> <?= GetMessage("BPTA1A_TASKASSIGNEDTO") ?>:</td>
	<td width="60%">
		<input type="text" name="task_assigned_to" id="id_task_assigned_to" value="<?= htmlspecialchars($arCurrentValues["task_assigned_to"]) ?>" size="50">
		<input type="button" value="..." onclick="BPAShowSelector('id_task_assigned_to', 'user');">
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_TASKACTIVEFROM") ?>:</td>
	<td width="60%">
		<span style="white-space:nowrap;"><input type="text" name="task_active_from" id="id_task_active_from" size="30" value="<?= htmlspecialchars($arCurrentValues["task_active_from"]) ?>"><?= CAdminCalendar::Calendar("task_active_from", "", "", true) ?></span>
		<input type="button" value="..." onclick="BPAShowSelector('id_task_active_from', 'datetime');">
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_TASKACTIVETO") ?>:</td>
	<td width="60%">
		<span style="white-space:nowrap;"><input type="text" name="task_active_to" id="id_task_active_to" size="30" value="<?= htmlspecialchars($arCurrentValues["task_active_to"]) ?>"><?= CAdminCalendar::Calendar("task_active_to", "", "", true) ?></span>
		<input type="button" value="..." onclick="BPAShowSelector('id_task_active_to', 'datetime');">
	</td>
</tr>

<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_TASKDETAILTEXT") ?>:</td>
	<td width="60%">
		<textarea name="task_detail_text" id="id_task_detail_text" rows="7" cols="40"><?= htmlspecialchars($arCurrentValues["task_detail_text"]) ?></textarea>
		<input type="button" value="..." onclick="BPAShowSelector('id_task_detail_text', 'string');">
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_TASKPRIORITY") ?>:</td>
	<td width="60%">
		<select name="task_priority">
			<?
			foreach ($arTaskPriority as $key => $value)
			{
				?><option value="<?= $key ?>"<?= $arCurrentValues["task_priority"] == $key ? " selected" : "" ?>><?= $value ?></option><?
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td align="right" width="40%"> <?= GetMessage("BPTA1A_TASKGROUPID") ?>:</td>
	<td width="60%">
		<select name="task_group_id" id="id_task_group_id">
			<?
			foreach ($arGroups as $key => $value)
			{
				?><option value="<?= $key ?>"<?= $arCurrentValues["task_group_id"] == $key ? " selected" : "" ?>><?= $value ?></option><?
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_CHANGE_DEADLINE") ?>:</td>
	<td width="60%">
		<input type="checkbox" name="task_change_deadline" id="id_task_change_deadline" <?= ($arCurrentValues["task_change_deadline"] == "Y")? "checked":""?>>
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_CHECK_RESULT") ?>:</td>
	<td width="60%">
            <input type="checkbox" name="task_check_result" id="id_task_check_result" <?= ($arCurrentValues["task_check_result"] == "Y")? "checked":""?>>
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_ADD_TO_REPORT") ?>:</td>
	<td width="60%">
		<input type="checkbox" name="task_report" id="id_task_report" <?= ($arCurrentValues["task_report"] == "Y")? "checked":""?>>
	</td>
</tr>
<tr>
	<td align="right" width="40%"><?= GetMessage("BPTA1A_TASKTRACKERS") ?>:</td>
	<td width="60%">
		<input type="text" name="task_trackers" id="id_task_trackers" value="<?= htmlspecialchars($arCurrentValues["task_trackers"]) ?>" size="50">
		<input type="button" value="..." onclick="BPAShowSelector('id_task_trackers', 'user');">
	</td>
</tr>