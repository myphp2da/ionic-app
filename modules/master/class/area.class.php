<?php 
class area extends master
{ 
    protected $_table = 'mst_areas';
    protected $_city_table = 'mst_cities';
    protected $_state_table = 'mst_states';
	
	function getArea($where) {
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResult($sql);
	}

	/** getting area from id
	 * @param int $id :$where is pass particular id
     * @return array | int : Returns array of area data for provided ID on success,
     *                     otherwise returns 404
	 */
	function getAreaByID($id) {
		$where = "id = ".$id;
		return $this->getArea($where);
	}
	/** getting Total Area Count rows related to id
	 ** @param  $where :$where is pass particular id
	 *  @return int :Send particular count
	 */
	function getAreaCount($where = '1') {
		$sql = "select count(id) as total_rows from ".$this->_table." where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}
	/** getting Area related to id
	 * @param  $where : $where is pass particular id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getAreaByPage($where = '1', $page = '1') {
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResults($sql, $page, 'paged');
	}

	/** Save Area details from Area details array
	 * @param array $data : Array of Area
	 * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertArea($data) {
		$insert = $this->dataArray($data);
		return $this->insertByArray($this->_table, $insert);
	}
	/** Update data as per particular id
	 * @param array $data : Array with key and value
	 * @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateArea($data) {
		$update = $this->dataArray($data);
		return $this->updateByArray($this->_table, $update, "id = ".$data['ID']);
	}
	
	function dataArray($data) {

		$ID = isset($data['ID']) ? $data['ID'] : 0;

		$input_name = str_replace('-', '_').'_name';
		$name = ucwords(str_replace('-', ' '));

		$db_name_field = 'str'.str_replace(' ', '', $name);
				
		$slug = String::generateSEOString($data[$input_name]);
		$slug = generateUniqueName($slug, $ID, $this->_table, 'strSlug', 'id', '1');
					
		$modified = array(
			$db_name_field => $data[$input_name],
			'strSlug' => $slug,
			'tinStatus' => '1',
			'dtiLastUpdated' => TODAY_DATETIME
		);
		
		if(isset($data['description'])) {
			$modified['txtDescription'] = $data['description'];
		}
		
		return $modified;
	}
	/** getting All area
	 * @param  $where : $where condition with id
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getAreas($where = '1') {
		$sql = "select main.*, c.strCity, s.strState
                from ".$this->_table." as main
                inner join ".$this->_city_table." as c
                    on c.id = main.idCity
                inner join ".$this->_state_table." as s
                    on s.id = main.idState
                where ".$where."
                    order by main.strArea";
		return $this->getResults($sql);
	}
}