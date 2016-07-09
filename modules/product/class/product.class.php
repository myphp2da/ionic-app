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

    /** @var string
     * Product quantity relation table name
     */
	protected $_product_quantity_table = 'rel_product_quantities';

    /** @var string
     * Cart master table name
     */
    protected $_cart_table = 'rel_cart';

    /** @var string
     * Quantity master table name
     */
    protected $_quantity_table = 'mst_quantities';

    /** @var string
     * Cart products master table name
     */
    protected $_cart_products_table = 'rel_cart_products';

    /** Complete order for provided details
     *
     * @param array $cart_data: cart data to complete the order
     * @return int | bool : Returns affected rows on success, otherwise returns 404
     */
    public function completeOrder($cart_data) {
        $cart_array = array(
            'intAddress' => $cart_data['address'],
            'strSlot' => $cart_data['slot'],
            'strPayment' => $cart_data['payment'],
            'tinStatus' => $cart_data['status']
        );
        return $this->updateByArray($this->_cart_table, $cart_array, "id = ".$cart_data['cart']);
    }

    /** Get cart for provided cart ID
     * @param array $cart_id: ID of the cart
     * @return array | int : Returns cart details for provided cart ID on success,
     *                     otherwise returns 404
     */
    public function getCart($cart_id) {
        $sql = "select c.*
                from ".$this->_cart_table." as c
                where c.id = ".$cart_id;
        return $this->getResult($sql);
    }

    /** Get cart product for provided cart ID and Product ID
     * @param array $cart_id: ID of the cart
     * @param array $product_id: ID of the product
     * @return array | int : Returns cart product details for provided cart ID and product ID on success,
     *                     otherwise returns 404
     */
    public function getCartProduct($cart_id, $product_id) {
        $sql = "select cp.*
                from ".$this->_cart_products_table." as cp
                where cp.idCart = ".$cart_id."
                    and cp.idProduct = ".$product_id;
        return $this->getResults($sql);
    }

    /** Get product quantity details for data provided
     *
     * @param int $product_id : ID of the product
     * @param int $quantity_id : ID of product quantity
     *
     * @return array | int : returns array of product quantity details on success,
     *                      otherwise returns 404
     */
    public function getProductQuantity($product_id, $quantity_id) {
        $sql = "select *
                from ".$this->_product_quantity_table."
                where idProduct = ".$product_id."
                    and idQuantity = ".$quantity_id;
        return $this->getResult($sql);
    }

    /** Getting all cart products for provided cart ID
     ** @param array $cart_id: Cart ID to fetch all products
     *  @return int :Send particular count
     */
    function getProductsByCartID($cart_id) {
        $sql = "select p.strProduct, p.strImageName, cp.*, pq.strRemarks, q.strQuantity
                from ".$this->_cart_products_table." as cp
                inner join ".$this->_table." as p
                    on p.id = cp.idProduct
                inner join ".$this->_product_quantity_table." as pq
                    on pq.idProduct = p.id and pq.idQuantity = cp.idQuantity
                inner join ".$this->_quantity_table." as q
                    on q.id = pq.idQuantity
                where cp.idCart = ".$cart_id;
        return $this->getResults($sql);
    }

    /** Update cart product for provided data
     *
     * @param array $cart_data: cart data to be updated
     * @return int | bool : Returns affected rows on success, otherwise returns 404
     */
    public function updateCart($cart_data) {
        $cart_array = array(
            'intQuantity' => $cart_data['quantity'],
            'decTotalAmount' => $cart_data['total_amount']
        );
        return $this->updateByArray($this->_cart_products_table, $cart_array, "idProduct = ".$cart_data['product']." and idCart = ".$cart_data['cart']);
    }

    /** Create a cart for customer ID provided
     *
     * @param int $customer_id : Customer ID for the cart
     * @return int | bool : Returns cart id generated on success, otherwise returns 404
     */
    public function createCart($customer_id) {
        $cart_array = array(
            'idCustomer' => $customer_id,
        );
        return $this->insertByArray($this->_cart_table, $cart_array);
    }

    /** Insert product to the cart for provided data
     * @param array $posted_data : Data to be added
     * @return int | false : Returns last inserted ID on success,
     *                      otherwise returns false
     */
    public function insertCartProduct($posted_data) {
        $insert_array = array(
            'idProduct' => $posted_data['product'],
            'idQuantity' => $posted_data['quantity'],
            'intQuantity' => $posted_data['total_quantity'],
            'idCart' => $posted_data['cart'],
            'decAmount' => $posted_data['amount'],
            'decTotalAmount' => $posted_data['total_amount']
        );
        return $this->insertByArray($this->_cart_products_table, $insert_array);
    }

    /** Update cart product for provided data
     * @param array $posted_data : Data to be updated
     * @return int | false : Returns affected rows on success,
     *                      otherwise returns false
     */
    public function updateCartProduct($posted_data) {
        $update_array = array(
            'idQuantity' => $posted_data['quantity'],
            'intQuantity' => $posted_data['total_quantity'],
            'decTotalAmount' => $posted_data['total_amount']
        );
        return $this->updateByArray($this->_cart_products_table, $update_array, "idProduct = ".$posted_data['product']." and idCart = ".$posted_data['cart']);
    }

    /** Update product quantity for provided data
     * @param array $posted_data : Data to be updated
     * @return int | false : Returns affected rows on success,
     *                      otherwise returns false
     */
    public function updateProductQuantity($posted_data) {
        $update_array = array(
            'decPrice' => $posted_data['price'],
            'strRemarks' => $posted_data['remarks']
        );
        return $this->updateByArray($this->_product_quantity_table, $update_array, "idProduct = ".$posted_data['product']." and idQuantity = ".$posted_data['quantity']);
    }

	/** Insert product quantity for provided data
	 * @param array $posted_data : Data to be added
	 * @return int | false : Returns last inserted ID on success,
	 *                      otherwise returns false
	 */
	public function insertProductQuantity($posted_data) {
		$insert_array = array(
			'idProduct' => $posted_data['product'],
			'idQuantity' => $posted_data['quantity'],
            'decPrice' => $posted_data['price'],
			'strRemarks' => $posted_data['remarks']
		);
		return $this->insertByArray($this->_product_quantity_table, $insert_array);
	}

    /** Getting all product quantities
     ** @param array $products: Array of products to fetch limited records
     *  @return int :Send particular count
     */
    function getProductQuantities($products = array()) {

        $where_string = (sizeof($products) > 0) ? " and idProduct in (".implode(",", $products).")" : '';

        $sql = "select pq.*, q.strQuantity
                from ".$this->_product_quantity_table." as pq
                inner join ".$this->_quantity_table." as q
                    on q.id = pq.idQuantity
                where 1".$where_string;
        return $this->getResults($sql);
    }

	/** getting Total Product Count rows related to productid
	 ** @param  $where :$where is pass particular productid
	 *  @return int :Send particular count
	 */
	public function getProductsCount($where) {
		$sql = "select count(id) as total_rows from ".$this->_table." as p where ".$where;
		$data = $this->getResult($sql);
		return $data['total_rows'];
	}

    /** Get category details for provided category ID
     * @param int $category_id : ID of the category ID
     * @return array | bool : Returns array of category details on success, otherwise returns false
     */
    public function getCategoryByID($category_id){
        $sql = "select * from ".$this->_category_table." where id = ".$category_id;
        return $this->getResult($sql);
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