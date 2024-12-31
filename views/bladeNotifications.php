<?php
if( $notifications = selectDB("notifications","`status` = '0' ORDER BY `id` DESC") ){
}
?>
<div class="row">
	<div class="col-md-12">  
		<div class="start-page-title with-white-bg text-center mb-4 p-3">
			<h4 class="mb-0 notication-page-title"><i class="bi bi-bell"></i> <?php echo Trans('app','Notifications'); ?> <span class="badge bg-secondary">0</span></h4> 
		</div>
	</div>
	<div class="col-md-12">
		<section class="section-50">
			<div class="containerX">
				<div class="notification-ui_dd-content">
					<?php
					$counter = 0;
					for( $i = 0; $i < sizeof($notifications); $i++ ){
						if( !isset($notifications[$i]['listOfUsers']) || empty($notifications[$i]['listOfUsers']) ){
							$notifications[$i]['listOfUsers'] = json_encode(array());
						}
						$listOfUsers = json_decode($notifications[$i]['listOfUsers'],true);
						if( in_array($userDetails['id'],$listOfUsers) ){
							$seen = "";
						}else{
							$seen = "notification-list--unread";
							array_push($listOfUsers,$userDetails['id']);
							updateDB('notifications',array('listOfUsers'=> json_encode($listOfUsers)),"`id` = '{$notifications[$i]['id']}'");
							$counter++;
						}
						?>
						<div class="notification-list <?php echo $seen; ?>">
							<div class="notification-list_content">
								<div class="notification-list_img">
									<img src="logos/<?php echo $userDetails['logo']; ?>" class="img-fluid" alt="..." style="border-radius: 100%;height: 58px;width: 100%;">
								</div>
								<div class="notification-list_detail">
									<p><b><?php echo $notifications[$i]['title']; ?></b></p>
									<p class="text-muted"><?php echo $notifications[$i]['body']; ?></p>
									<p class="text-muted"><small><?php echo $notifications[$i]['date']; ?></small></p>
								</div>
							</div>
							<div class="notification-list_feature-img">
								<i class="bi bi-bell"></i> 
							</div>
						</div>
						<?php
					}
					?>
					<span style="display: none;" id="NotSeen"><?php echo $counter; ?></span>
				</div>
			</div>
		</section>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var unseen = document.getElementById("NotSeen").textContent;
  var badges = document.querySelectorAll(".badge");
  for (var i = 0; i < badges.length; i++) {
    badges[i].textContent = unseen;
  }
});
</script>