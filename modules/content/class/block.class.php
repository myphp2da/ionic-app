<?php 
class block extends content {

    protected $_mst_block = 'mst_blocks';
    protected $_rel_content_blocks = 'rel_content_blocks';
    protected $_rel_block_details = 'rel_block_details';

	/** Insert content block from relations provided
	 * @param array $data : Array of content block relations
	 * @return int | bool : returns last content block ID on success, otherwise returns false
	 */
	function insertContentBlock($data) {

        $content_block_array = array(
            'intContentId' => $data['content'],
            'intBlockId' => $data['block'],
            'intPosition' => $data['position'],
            'intCreatedBy' => $_SESSION[PF.'USERID'],
            'dtiCreated' => TODAY_DATETIME
        );

		return $this->insertByArray($this->_rel_content_blocks, $content_block_array);
	}

    /** Insert block details from details array provided
     * @param array $data : Array of block details
     * @return int | bool : returns last block details ID on success, otherwise returns false
     */
    function insertBlockDetails($data) {

        $block_details_array = array(
            'intContentBlockId' => $data['content_block'],
            'txtContent' => $data['details']
        );

        if(isset($data['latitude']) || isset($data['longitude'])) {
            $block_details_array['decLatitude'] = $data['latitude'];
            $block_details_array['decLongitude'] = $data['longitude'];
        }

        return $this->insertByArray($this->_rel_block_details, $block_details_array);
    }

	/** Getting type of blocks for content
	 * @param  $where : Where query to filter records
	 * @return int|array : return 404 if no data available for the query,
	 *                     otherwise return array of results
	 */
	function getBlocks($where = ''){
		$sql = "select * from ".$this->_mst_block." where tinStatus = '2' and tinStatus = '1'".$where;
		return $this->getResults($sql);
	}

    /** Get content block details for content ID provided
     *
     * @param int $content_id : Content ID to fetch content block details
     * @return int | array : Returns array of content block details for content ID provided on success,
     *                     otherwise returns 404
     */
    public function getBlockDetailsByContentID($content_id) {

        $this->setPrepare(array(':content_id' => $content_id));

        $sql = "select bl.*, bl.intContentBlockId as content_block_id, b.strSlug as block_slug, b.id as block_id
                from ".$this->_rel_block_details." as bl
                inner join ".$this->_rel_content_blocks." as cb
                    on cb.id = bl.intContentBlockId and cb.intContentId = :content_id
                inner join ".$this->_mst_block." as b
                    on b.id = cb.intBlockId
                order by bl.intPosition, cb.intPosition";
        return $this->getResults($sql);

    }
}