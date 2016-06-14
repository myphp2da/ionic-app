<?php
if (!$account_obj->checkAccess('customer', 'list')) {
	_error('unauthorized');
	exit;
}
?>
<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="account/load/customers" data-container="#customerList" data-action="add" data-lib="dataTable"
   style="display:none;"></a>
<?php
_subModule('account', 'customer');
$customer_obj = new customer();

$qAdd = "main.tinStatus != '2' and main.enmActivated='1'";
if (isset($_POST['q']) && !empty($_POST['q'])) {
	$qAdd .= " and concat(strFirstName, strLastName) like ('%" . $_POST['q'] . "%')";
}

$customer_count = $customer_obj->getCustomersCount($qAdd);

if ($customer_count != 0) {
$customers = $customer_obj->getCustomers($qAdd);
?>
<div class="adv-table">
	<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
		<thead>
		<tr class="headBorder">
			<th class="number" width="5%">#</th>
			<th>Name</th>
			<th width="20%">Phone</th>
			<th width="20%">Birth Date</th>
			<th width="5%">Orders</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$cnt = 1;
		foreach ($customers as $customer) {
			if ($customer['tinStatus'] == '1') {
				$class1 = "class='fa fa-eye _green ajaxButton'";
				$title1 = "title='Click to Deactivate'";
			} else {
				$class = "class='fa fa-eye-slash _red ajaxButton'";
				$title = "title='Click to Activate'";
			}
			?>
			<tr>
				<td class="number"><?php echo $cnt++; ?></td>
				<td>
					<a href="<?php _e($module_url); ?>/profile?id=<?php _e($customer['id']); ?>"><?php _e($customer['strFirstName'] . ' ' . $customer['strLastName']); ?></a><br/>
					<?php _e($customer['strEmail']); ?>
				</td>
				<td><?php _e($customer['dblPhone']); ?></td>
				<td><?php _e(Date::displayDate($customer['dtBirth'])); ?></td>
				<td>View</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
			<tr>
				<td height="50" align="center">No Customer available.</td>
			</tr>
		</table>
	<?php } ?>
</div>