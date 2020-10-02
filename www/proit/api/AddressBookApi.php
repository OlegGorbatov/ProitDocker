<?php
require_once('models/AddressBookModel.php');
require_once 'Api.php';

/**
 * Дочерний класс работы с API
 *
 * @author Oleg Gorbatov <o.i.gorbatov@yandex.ru>
 */
class AddressBookApi extends Api
{
    protected $limit = 0;

    /**
     * AddressBookApi constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Получение данных, для отправки их на фронт
     *
     * @return object | boolean $data
     */
    public function viewAction()
    {
        if (array_key_exists('numberRecords', $this->requestParams)) {
            $this->limit = (int) $this->requestParams['numberRecords'];
        }

        $content = new AddressBookModel();
        $data = $content->getData($this->limit);
        if ($data) {
            return $this->response($data, 200);
        } else {
            $data = ['status'  => 'Error: '.AddressBookModel::$errorMessage];
            return $this->response($data, 500);
        }
    }

    /**
     * @throws RuntimeException
     */
    public  function createAction() {
        $contact = $this->postParams;
        if (is_string($contact)){
            $content = new AddressBookModel();
            $content->createNewContact($contact);
        } else {
            throw new RuntimeException('Invalid Data', 405);
        }

        if (empty(AddressBookModel::$errorMessage)) {
            $data = ['status' => 'Contact was recorded'];
            return $this->response($data, 200);
        } else {
            $data = ['status' => 'Error: '.AddressBookModel::$errorMessage];
            return $this->response($data, 500);
        }
    }
}