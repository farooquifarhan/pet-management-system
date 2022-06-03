<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>

<?php 
 if(!$_GET['id'] OR empty($_GET['id']) OR $_GET['id'] == '')
 {
 	header('location: manage-dog.php');

 }else{
 	
 	$dogno = $bname = $b_id = $health = "";
 	$id = (int)$_GET['id'];
 	$query = $db->query("SELECT * FROM dogs WHERE id = '$id' ");
 	$fetchObj = $query->fetchAll(PDO::FETCH_OBJ);

 	foreach($fetchObj as $obj){
       $dogno = $obj->dogno;
	   $b_id = $obj->breed_id;
	   $health = $obj->health_status;

	     $k = $db->query("SELECT * FROM breed WHERE id = '$b_id' ");
       	 $ks = $k->fetchAll(PDO::FETCH_OBJ);
       	 foreach ($ks as $r) {
       	 	$bname = $r->name;
       	 }
 	}
 }

?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dog Management</b></h5>
  </header>
 
 <?php include 'inc/data.php'; ?>

 
 <div class="w3-container" style="padding-top:22px">
	 <div class="w3-row">
	 	<h2>Quarantine List</h2>
	 	<div class="col-md-6">
	 		<table class="table table-hover" id="table">
	 			<thead>
	 				<tr>
	 					<th>Dog No</th>
	 					<th>Date quarantined</th>
	 					<th>Breed</th>
	 					<th>Reason</th>
	 				</tr>
	 			</thead>
	 			<tbody>
	 				<?php

	 				$get = $db->query("SELECT * FROM quarantine");
	 				$res = $get->fetchAll(PDO::FETCH_OBJ);
	 				foreach($res as $n){ ?>
                         <tr>
                         	<td> <?php echo $n->dog_no; ?> </td>
                         	<td>  <?php echo $n->date_q; ?> </td>
                         	<td><?php echo $n->breed; ?> </td>
                         	<td> <?php echo $n->reason; ?> </td>
                         </tr> 
	 				<?php }

	 				?>
	 			</tbody>
	 		</table>
	 	</div>

	 	<div class="col-md-6">

     <?php
      if(isset($_POST['submit']))
      {
      	$n_dogno = $_POST['dogno'];
     
      	$n_breed = $_POST['breed'];
      	$n_remark = $_POST['reason'];
      	$now = date('Y-m-d');
  

      	$n_id = $_GET['id'];

      	$insert_query = $db->query("INSERT INTO quarantine(dog_no,breed,reason,date_q)VALUES('$n_dogno','$n_breed','$n_remark','$now') ");

      	if($insert_query){?>
      	<div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Dog successfully quarantined <i class="fa fa-check"></i></strong>
        </div>
       <?php
         header('refresh: 5');
      	}else{ ?>
          <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error inserting dog data. Please try again <i class="fa fa-times"></i></strong>
        </div>
      	<?php
      }

      }

     ?>


	 		<form role='form' method="post">
	 			<div class="form-group">
	 				<label class="control-label">Dog No</label>
	 				<input type="text" name="dogno" readonly="on" class="form-control" value="<?php echo $dogno; ?>">
	 			</div>

	 			<div class="form-group">
	 				<label class="control-label">Breed</label>
	 				<input type="text" name="breed" readonly="on" class="form-control" value="<?php echo $bname; ?>">
	 			</div>

	 			<div class="form-group">
	 				<label class="control-label">Reason</label>
	 				<textarea name="reason" placeholder="Enter reason for quarantine" class="form-control" value=""></textarea>
	 			</div>

	 			<button name="submit" type="submit" class="btn btn-sm  btn-default">Add to list</button>
	 		</form>
	 	</div>
	 </div>
</div>

</div>

<?php include 'theme/foot.php'; ?>