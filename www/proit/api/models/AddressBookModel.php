<?php
require_once 'DbConnect.php';
/**
 * Класс для работы с данными Адрес модели
 *
 * @author Oleg Gorbatov <o.i.gorbatov@yandex.ru>
 */
class AddressBookModel
{
    static public $errorMessage = '';
    protected $db = '';

    /**
     * AddressBookModel constructor. Подключается к базе данных используя класс DbConnect
     */
    public function __construct()
    {
        $this->db = DbConnect::getConnection();
    }

    /**
     * AddressBookModel getData. Получает данные из бд, может ограничивать их кол-во если передан параметр limit
     *
     * @param int $limit
     * @return object | boolean $data
     */
    public function getData(int $limit)
    {
        if (!($this->db instanceof PDO)) {
            self::$errorMessage = 'Error in dbConnect';
            return FALSE;
        }

        if ($limit > 0) {
            $dbLimit = ' LIMIT ' . $limit;
        } else {
            $dbLimit = '';
        }

        $data = FALSE;
        try {
            $data = $this->db->query("SELECT * FROM `content` $dbLimit" )->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            self::$errorMessage = 'Unable read data';
        }
        return $data;
    }

    /**
     * Создаёт новый контакт в БД
     *
     * @param string $data
     */
    public function createNewContact($data) {
        if (!($this->db instanceof PDO)) {
            self::$errorMessage = 'Error in dbConnect';
            exit();
        }

        $data = json_decode($data);

        isset($data->fio) ? $fio = (string) $data->fio : $fio = '' ;
        isset($data->email) ? $email = (string) $data->email : $email = '';
        isset($data->phone) ? $phone = (string) $data->phone : $phone = '';
        isset($data->city) ? $city = (string) $data->city : $city = '';
        isset( $data->addressLine) ? $address = (string) $data->addressLine : $address = '';

        try {
            $sth = $this->db->prepare("
                INSERT INTO `content` 
                SET 
                    `fio` = :fio, 
                    `email` = :email,
                    `phone` = :phone,
                    `city` = :city,
                    `addressLine` = :address
                ");
            $sth->execute(array(
                'fio' => $fio,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'address' => $address
            ));
            self::$errorMessage = $sth->errorInfo();
        } catch(PDOException $e) {
            self::$errorMessage = 'Unable write data '.json_encode($e);
        }
    }
}


//$conf = [
//    'host' => 'localhost',
//    'type' => 'mysql',
//    'name' => 'proit_test',
//    'user' => 'root',
//    'pass' => 'root',
//    'collocation' => 'utf8_general_ci',];
//$t = new AddressBookModel($conf, 2);
////$cnt = $t->createNewContact();
//$cnt = $t->getData();
//echo $cnt;

