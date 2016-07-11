 <!-- Modal -->
  <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"  style="background: #458070;" >
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"  style="color:white;"><b><i>Help Items</b></i></h4>
        </div>
        <div class="modal-body">
          <div class="row header contact">
			<div class="col-lg-12" >
			<div class="table">
			<div class=".col-lg-12 col-md-12 col-sm-6" >
			
			 </div>
			<div class="row" >
			<table id="quick_keys" class="table table-bordered">
				<thead>
					<tr>
					<td colspan = '2'>Hot Key Reference Guide - <b>" Shift + H "</b></td>
					
					</tr>
				</thead>
				<tbody >
					
					<tr><td class="text-right">Clone the Last Quote</td><td>Control + Shift + 1</td></tr>
					<tr><td class="text-right">Clone the Last Booking</td><td>Control + Shift + 2</td></tr>
					<tr><td class="text-right">Use the Last Customer</td><td>Shift + 6</td></tr>
				 
				</tbody>
			 </table>
			 </div>
			  <div  class=".col-lg-10 .col-lg-offset-2  .col-md-10 .col-md-offset-2  .col-sm-6" >
			 	<div class="text-muted"><span>Use "Hot Keys" to speed it up. Click <a href="<?php echo HTTP_HELP;?>HotKeys" target="_blank">here</a> for more information about how to use Hot Keys.</a></span> </div>
			 </div><!-- end row -->
			</div> 
			   
			 </div> 
        </div>
        <div class="modal-footer">
         
          <button type="button" class="btn btn-default" data-dismiss="modal">Finished</button>
          
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal --> 
  
  <script type="text/javascript"><!--
function manageHelp(){	  $('#helpModal').modal('show');	  	}
//--></script> 

<script type="text/javascript">$(document).ready(function() {
		
		

		 shortcut.add("SHIFT+H",function() {
			
		manageHelp();
			//customer_no
			//$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customer_code', 'value':'<?php echo $customer_object->customer ?>'});
			//ContactModal('<?php echo $customer_object->customer ?>');	
		});

	});
	
	//--></script>
	
	<script type="text/javascript">$(document).ready(function() {
	 shortcut.add("Shift+6",function() {
		var customer_object = <?php echo json_encode($customer_object); ?>;
		if (typeof customer_object == 'undefined'){	
			alert("No Previous Customer information is avaiable!");
			var customer_object=null;
			var input_customer = null;
			var input_customerName = null;
			var input_customerAddress1 = null;
			var input_customerCity = null;
			var input_customerState = null;
			var input_customerZip = null;
			var input_customercontact = null;
			var input_custtelephone = null;
			var input_custemail = null;
			var input_custfax = null;
			
		} else {
			
			var input_customerdetail = customer_object["customerdetail"];
			var input_customer = customer_object["customer"];
			var input_customerName = customer_object["customerName"];
			var input_customerAddress1 = customer_object["customerAddress1"];
			var input_customerCity = customer_object["customerCity"];
			var input_customerState = customer_object["customerState"];
			var input_customerZip = customer_object["customerZip"];
			var input_customercontact = customer_object["customercontact"];
			var input_custtelephone =customer_object["custtelephone"];
			var input_custemail = customer_object["custemail"];
			var input_custfax = customer_object["custfax"];
		
		}
		
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'test_hotkey', 'value':customer_object});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customer_code', 'value':input_customer});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customer', 'value':input_customer});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerName', 'value':input_customerName});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerAddress1', 'value':input_customerAddress1});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerCity', 'value':input_customerCity});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerState', 'value':input_customerState});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerZip', 'value':input_customerZip});
		$.post('controller/setting/ajaxpersist.php', { 'fieldname' : 'customerdetail','value':input_customerdetail});
		
		$('input[name=\'customerName\']').val(input_customerName);
		$('input[name=\'customerAddress1\']').val(input_customerAddress1);
		$('input[name=\'customerCity\']').val(input_customerCity);
		$('input[name=\'customerState\']').val(input_customerState);
		$('input[name=\'customerZip\']').val(input_customerZip);
		$('input[name=\'customercontact\']').val(input_customercontact);
		$('input[name=\'custtelephone\']').val(input_custtelephone);
		$('input[name=\'custemail\']').val(input_custemail);
		
		
		ContactModal('<?php echo $customer_object->customer ?>');	
	});

	});
	//--></script> 
	
	<script type="text/javascript">$(document).ready(function() {
	 shortcut.add("Ctrl+Shift+2",function() {
		var booking_object = <?php echo json_encode($booking); ?>;
		
		if (typeof booking_object == 'undefined'){	
			alert("No Previous Booking information is avaiable!");
			var booking_object=null;
			
			
		} else {
			
			var input_booking_object = booking_object;
		}
		
	 }
	 
	});
		//--></script> 
	