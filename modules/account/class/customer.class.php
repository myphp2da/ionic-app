<?php

class customer extends account
{
	/** @var string
	 * Customer master table name
	 */
	protected $_customer_table = 'mst_customers';

	/** @var string
	 * Customer Addresses master table name
	 */
	protected $_customer_addresses_table = 'rel_customer_addresses';

    /** @var string
     * Areas master table name
     */
    protected $_area_table = 'mst_areas';

    /** Update last check date for customer
     * @params $id: Customer ID to update last check date
     * @return int | bool : Returns affected rows on success,
     *                    otherwise returns false
     */
    public function updateLastCheck($id) {
        $update_array = array(
            'dtiLastCheck' => TODAY_DATETIME
        );
        return $this->updateByArray($this->_customer_table, $update_array, "id = ".$id);
    }

	/** Get all customer addresses for Customer ID provided
	 * @param int $customer_id : Customer ID
	 * @return array | int : returns Array of customer addresses for provided Customer ID on success,
	 *                      otherwise returns 404
	 */
	public function getCustomerAddresses($customer_id) {
		$sql = "select a.*, ar.strArea 
				from " . $this->_customer_addresses_table . " as a
				inner join ".$this->_area_table." as ar
				    on ar.id = a.idArea
				where a.idCustomer = " . $customer_id;
		return $this->getResults($sql);
	}

	/** Get all customer data and access details for Customer ID provided
	 * @param int $id : Customer ID
	 * @return array | int : returns Array of customer and access_types table for provided Customer ID on success, otherwise returns 404
	 */
	function getCustomerDetail($id)
	{
		$sql = "select main.*, desg.strAccessType
				from " . $this->_table . " as main
				inner join " . $this->_access_type_table . " as desg
				on desg.id = main.idDesg
				where main.id = " . $id;
		return $this->getResult($sql);
	}

	/** Get count number of table mst_customers
	 * @param string $where : condition of SQL statement to be executed
	 * @return int|array : return 404 if no data available for the query,
	 *                      otherwise return array of results
	 */
	function getCustomersCount($where)
	{
		$sql = "select count(main.id) as total_rows from " . $this->_customer_table . " as main where " . $where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

    /** Update customer address for provided data
     * @param array $post_data : Posted data to be updated
     * @return int | bool : Returns affected rows on success,
     *                      otherwise returns false
     */
    public function updateCustomerAddress($post_data) {
        $address_array = $this->customerAddressArray($post_data);
        return $address_id = $this->updateByArray($this->_customer_addresses_table, $address_array, "id = ".$post_data['id']);
    }

	/** Insert customer address for provided data
	 * @param array $post_data : Posted data to be inserted
	 * @return int | bool : Returns last inserted ID on success,
	 *                      otherwise returns false
	 */
	public function insertCustomerAddress($post_data) {
        $address_array = $this->customerAddressArray($post_data);
        return $address_id = $this->insertByArray($this->_customer_addresses_table, $address_array);
	}

    /** Parse customer address array as per data provided
     *
     * @param array $post_data : Array of data to be parsed
     * @return array : Returns parsed array on success
     */
    public function customerAddressArray($post_data) {
        $address_array = array(
            'strFirstName' => $post_data['fname'],
            'strLastName' => $post_data['lname'],
            'strLabel' => $post_data['label'],
            'idArea' => $post_data['area'],
            'strAddressLine1' => $post_data['address1'],
            'strAddressLine2' => $post_data['address2'],
            'strCity' => $post_data['city'],
            'strState' => $post_data['state'],
            'intPinCode' => $post_data['pincode'],
            'idCustomer' => $post_data['customer']
        );

        return $address_array;
    }

	public function insertCustomer($data)
	{
		$modified = $this->customerArray($data);
		return $this->insertByArray($this->_customer_table, $modified);
	}

	public function customerArray($data)
	{
		$modified = array(
			'strFirstName' => $data['fname'],
            'strLastName' => $data['lname'],
			'strEmail' => $data['email'],
            'dblPhone' => $data['phone'],
			'strActivation' => $data['activation']
		);

		if (isset($data['password']) && !empty($data['password'])) {
			$modified['strPassword'] = $data['password'];
		}

		return $modified;
	}

	/** getting customers detail from where condition
	 * @param $where       : Where means particular condition
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	public function getCustomers($where) {
		$sql = "select main.*
				from " . $this->_customer_table . " as main
				where " . $where;
		return $this->getResults($sql);
	}

	/** getting customer detail from ID as per the condition
	 * @param $id : id to the particular customer
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getCustomerByID($id)
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where main.id = " . $id;
		return $this->getResult($sql);
	}

	/** getting customer detail from where condition
	 * @param $where       : Where means particular condition
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getCustomer($where)
	{
		$sql = "select main.*
				from " . $this->_table . " as main
				where " . $where;
		return $this->getResult($sql);
	}

	/** Inserts data into rel_reset_password table
	 * @param array $data: array of the table field name and post data of the fields
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function addResetToken($data)
	{
		$this->insertByArray($this->_reset_password, $data);
	}
	/** Get reset-token from rel_reset_password and mst_customer tables with matching ID in both.
              @params $emailId:strEmailId from mst_customer,
                      $token:strToken from rel_reset_password
              @return:single array resultset return.
    */
	function getResetToken($emailId, $token) {
		 $sql = "select reset.*
				from ".$this->_reset_password." as reset
				inner join ".$this->_table." as main
					on main.id = reset.vId and main.strEmail = '".$emailId."'
				where reset.token = '".$token."'";
		return $this->getResult($sql);
	}

	/** This function verify the particular customer as per the condition
	 * @param $activation_code :  Activation code,
	 *                         $email_hash:As per the email hash
	 * @return int|array : return 404 if no data available for the query,
	 *                         otherwise return false
	 */
	function verifyCustomer($email_hash, $activation_code)
	{

		$sql = "select * from " . $this->_table . "
                where sha1(concat('" . PASSWORD_HASH . "', strEmail)) = '" . $email_hash . "'
                and tinStatus = '0' and strActivation = '" . $activation_code . "'";
		$data = $this->getResult($sql);

		if ($data != 404) {

			$where = "id = " . $data['id'];
			$data = array('tinStatus' => '1',
				'dtiLastLogin' => TODAY_DATETIME,
				'enmActivated' => '1');
			$this->updateCustomer($data, $where);
			return true;
		}

		return false;
	}

	/** Update data from customer table
	   @params $this->_table: mst_customer,
	   $where: id of the customer table to update,
	   $data:data array with fields and value
	*/
	function updateCustomer($data, $where)
	{
		return $this->updateByArray($this->_table, $data, $where);
	}

	/** This function check Login as well as duplication of Mobile or Email id at the time of registation
	 * @param string $username : email as checking
	 * @return it returns single result otherwise 404
	 */
	function checkCustomerLogin($username, $password = '')
	{
		$mainAdd = " AND main.strEmail = '" . $username . "'";
		if (!empty($password)) {
			$mainAdd .= " AND main.strPassword = '" . $password . "'";
		}

		$sql = "select main.id, strEmail, strFirstName, strLastName, strImageName, enmActivated, strEmail
				from " . $this->_customer_table . " as main
				where 1" . $mainAdd;
		return $this->getResult($sql);
	}
}
