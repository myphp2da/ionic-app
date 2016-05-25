<?php 
class product extends db_class {

	/** @var string
	 * Products master table name
	 */
	protected $_table = 'mst_products';

     /** @var string
     * Category master table name
     */
    protected $_category_table = 'mst_categories';

	protected $_product_quantity_table = 'rel_product_quantities';

	/** Insert product quantity for provided data
	 * @param array $posted_data : Data to be added
	 * @return int | false : Returns last inserted ID on success,
	 *                      otherwise returns false
	 */
	public function insertProductQuantity($posted_data) {
		$insert_array = array(
			'idProduct' => $posted_data['product'],
			'idQuantity' => $posted_data['quantity'],
			'strRemarks' => $posted_data['amount']
		);
		return $this->insertByArray($this->_product_quantity_table, $insert_array);
	}

	/** getting Total Product Count rows related to productid
	 ** @param  $where :$where is pass particular productid
	 *  @return int :Send particular count
	 */
	function getProductsCount($where) {
		$sql = "select count(id) as total_rows from ".$this->_table." as p where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}
	/** getting Product related to particular productid
	 * @param  $where : $where is pass particular productid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of result
	 */
	function getProduct($where){
		$sql = "select p.*
				from ".$this->_table." as p	where ".$where;
		return $this->getResult($sql);
	}

	function getProductBySlug($slug){
		$sql = "select * from ".$this->_table." where strSlug = '".$slug."'";
		return $this->getResult($sql);
	}

	/** getting Products related to productid
	 * @param  $where : $where is pass particular productid
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getProducts($where){
		$sql = "select p.*, c.strCategory as category_name
                from ".$this->_table." as p
                inner join ".$this->_category_table." as c
                    on c.id = p.idCategory
                where ".$where;
		return $this->getResults($sql);
	}

	/** Save Product details from Product details array
	 * @param array $data : Array of Product
	 * * @return bool|int : id of the row inserted otherwise false on failure
	 */
	function insertData($data) {
		return $this->insertByArray($this->_table, $data);
	}

	/** Update Product details from product details array with particular id
	 * @param array $data : Array of product
	 *              $id:Particular product's ID
	 *  @return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function updateData($data) {
		return $this->updateByArray($this->_table,$data,"id = ".$_POST['id']);
	}

	/** Softdelete Product details from Product details array with particular id
	 * @param array $data : Array of Product
	 *              $id:Particular Product's ID
	 *@return the number or row affected or true if no rows needed the update otherwise false on failure
	 */
	function delete_product($id,$data){
		$where='id='.$id;
		return $this->updateByArray($this->_table,$data,$where);
	}
}