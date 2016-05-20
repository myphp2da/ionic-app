<?php 
class page extends db_class {

	/** @var string
	 * Pages master table name
	 */
	protected $_table = 'mst_pages';

     /** @var string
     * Navigations links table name
     */
    protected $_links_table = 'rel_navigation_links';

	/** getting Total Page Count rows related to pageid
	 ** @param  $where :$where is pass particular pageid
	 *  @return int :Send particular count
	 */
	function getPagesCount($where) {
		$sql = "select count(id) as total_rows from ".$this->_table." where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}
	/** getting Page related to particular pageid
	 * @param  $where : $where is pass particular pageid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getPage($where){
		$sql = "select p.*
				from ".$this->_table." as p	where ".$where;
		return $this->getResult($sql);
	}
	/*function getPage($where){
		$sql = "select p.*
				from ".$this->_table." as p
				inner join ".$this->_links_table." as l
					on l.idPage = p.id
				where ".$where;
		return $this->getResult($sql);
	}*/

	function getPageBySlug($slug){
		$sql = "select * from ".$this->_table." where strSlug = '".$slug."'";
		return $this->getResult($sql);
	}

	/** getting Pages related to pageid
	 * @param  $where : $where is pass particular pageid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getPages($where){
		$sql = "select * from ".$this->_table." where ".$where; 
		return $this->getResults($sql);
	}

	/** Save Page details from Page details array
	 * @param array $data : Array of Page
	 * * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertData($data) {
		return $this->insertByArray($this->_table, $data);
	}

	/** Update Page details from page details array with particular id
	 * @param array $data : Array of page
	 *              $id:Particular page's ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateData($data) {
		return $this->updateByArray($this->_table,$data,"id = ".$_POST['id']);
	}

	/** Softdelete Page details from Page details array with particular id
	 * @param array $data : Array of Page
	 *              $id:Particular Page's ID
	 *@return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function delete_page($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_table,$data,$where);
	}

    /** Save contact details from contact details array
     * @param array $contact_data : Array of contacts
     * @return int | bool : returns last contact ID on success, otherwise returns false
     */
    public function saveContact($contact_data) {
        $contact_array = array(
            'strName' => $contact_data['name'],
            'strEmail' => $contact_data['email'],
            'strSubject' => $contact_data['subject'],
            'txtMessage' => $contact_data['message'],
            'dtiCreated' => TODAY_DATETIME,
        );
        return $this->insertByArray($this->_contact_table, $contact_array);
    }
}