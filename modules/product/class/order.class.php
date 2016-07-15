<?php 
class order extends product {

	/** @var string
     * Cart master table name
     */
    protected $_cart_table = 'rel_cart';

    /** @var string
     * Cart products master table name
     */
    protected $_cart_products_table = 'rel_cart_products';

    protected $_customer_table = 'mst_customers';

    protected $_products_table = 'mst_products';

    /** Get latest seq of orders
     * @return int : Returns latest sequence of orders
     */
    public function getOrderSeq() {
        $sql = "select max(intSeq) as max_seq from ".$this->_cart_table." where tinStatus = '2'";
        $data = $this->getResult($sql);
        return $data['max_seq'];
    }

    /** Get orders by status provided
     * @param int $status : Status of the order
     * @return array | int : Returns array of orders for provided status,
     *                      otherwise returns 404
     */
    public function getOrdersByStatus($status) {
        $sql = "select c.*, p.*
                from ".$this->_cart_table." as c
                inner join ".$this->_cart_products_table." as cp
                    on cp.idCart = c.id
                inner join ".$this->_products_table." as p
                    on p.id = cp.idProduct
                where c.tinStatus = '2'
                group by c.id";
        return $this->getResults($sql);
    }

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
            'tinStatus' => $cart_data['status'],
            'intSeq' => $cart_data['seq'],
            'dblOrderNo' => $cart_data['order_no']
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
}