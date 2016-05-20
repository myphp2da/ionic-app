<?php 
class content extends db_class {

	/** @var string
	 * Pages master table name
	 */
	protected $_table = 'mst_content';
	protected $_rel_content='rel_content';//relation table store category and content
	protected $_rel_tag = 'rel_tag';
	protected $_mst_tag = 'mst_tag';


	function getContentTag($where){
		$sql = "select mtag.strTag from ".$this->_table."  as mst_cnt
		join ".$this->_rel_tag." as rtag on mst_cnt.id=rtag.intContentID
		join ".$this->_mst_tag." as mtag on mtag.id=rtag.intTagID
		where ".$where." and  mtag.tinStatus = '1'
		and mtag.tinStatus = '2' ";
		return $this->getResults($sql);
	}

	function getFrontContent(){
		$sql = "(select id, strTitle, strContentType, strSlug from ".$this->_table."  where `strContentType` = 'n' order by dtiCreated desc LIMIT 3)
		UNION ALL
		(select id, strTitle, strContentType, strSlug from ".$this->_table." where `strContentType` = 'r' order by dtiCreated desc LIMIT 3)
		UNION ALL
		(select id, strTitle, strContentType, strSlug from ".$this->_table." where `strContentType` = 'c' order by dtiCreated desc LIMIT 3)
		UNION ALL
		(select id, strTitle, strContentType, strSlug from ".$this->_table." where `strContentType` = 'p' order by dtiCreated desc LIMIT 3)
		UNION ALL
		(select id, strTitle, strContentType, strSlug from ".$this->_table." where `strContentType` = 's' order by dtiCreated desc LIMIT 4)";

		return $this->getResults($sql);
		/* s= studio, p=products*/
	}

	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertData($data) {
		return $this->insertByArray($this->_table, $data);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getContents($where){
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResults($sql);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int : Send particular count
	 */
	function getContentCount($where) {

	    $sql = "select count(id) as total_rows from " . $this->_table . " where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];


	}
	/** Update content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateData($data) {
		return $this->updateByArray($this->_table,$data,"id = ".$_POST['id']);
	}

	/** Softdelete content details from Content details array with particular id
	 * @param array $data : Array of content
	 *              $id:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function deleteData($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_table,$data,$where);
	}
	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertCategoryData($data) {
		return $this->insertByArray($this->_rel_content, $data);
	}

	/** Save content details from Content details array
	 * @param array $data : Array of content
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function insertRelTagData($data) {
		return $this->insertByArray($this->_rel_tag, $data);
	}

	/** getting category reletd to content using Contentid
	 * @param  $contentid : particular contentid
	 * @return results set with array
	 */
	function getCategoryFromContent($contentid){
		$sql="SELECT mst_category.id,rel_content.intCategoryID FROM `mst_category` as mst_category
              INNER join rel_content as rel_content
                     on mst_category.id=rel_content.intCategoryID
              where rel_content.intContentID=$contentid";
		return $this->getResults($sql);
	}

	/** Update content Category in rel_content table related to  particular id
	 * @param array $data : Array of content
	 *              $where:Particular content's ID
	 * @return int | bool : returns last contact ID on success, otherwise returns false
	 */
	function updateCategoryData($data,$where) {
		return $this->updateByArray($this->_rel_content,$data,$where);
	}

	/** Delete category releated to content id from rel_content table
	 * @param  $where : Particular content's ID
	 * @return bool : returns true otherwise returns false
	 */
	function deleteCategory($where){
		return $this->deleteRows($this->_rel_content,$where);
	}

	/** getting Content reletd to Contentid
	 * @param  $where : $where is pass particular contentid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getContent($where){
		$sql = "select * from ".$this->_table." where ".$where;
		return $this->getResult($sql);
	}

	function deleteTag($where){
		return $this->deleteRows($this->_rel_tag, $where);
	}

	function getRelTag($id){

		$sql = "select mst_tag.strTag as tag_name from " . $this->_rel_tag . " as rel_tag
				join " . $this->_mst_tag . " as mst_tag
					on rel_tag.intTagID = mst_tag.id
				where mst_tag.tinStatus = '1'
					and mst_tag.tinStatus = '2'
					and rel_tag.intContentID = " . $id;

		return $this->getResults($sql);
	}
}