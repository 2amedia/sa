<? 
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if (!empty($_POST['name'])&&!empty($_POST['phone'])){
    $arEventFields = array(
        "NAME" => $_POST['name'],
        "PHONE" => $_POST['phone'],
        "EMAIL" => $_POST['email']
    );
    $result = CEvent::Send("landos", 's1', $arEventFields);
    if ($result > 0) {
        echo "<span  class='text-success' style='color:#3c763d;font-size: 18px;line-height: 22px;text-align: center;display: block;'>Ваше сообщение успешно отправлено. <br> Мы свяжемся с вами в ближайшее время</span>";
    } else {
        echo "<span class='text-danger'>Ошибка</span>";
    }
}
