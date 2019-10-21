<?php $this->load->view('templates/_include/header_view1'); ?>
<style>
	.chat-icon-img img{
		width: 50px !important;
		height: 50px !important;
	}
	.chatimg{
		width: 50px !important;
		height: 50px !important;
	}
</style>

<div class="container">
	<div class="col-md-12 col-xs-12">
	    <div class="proinbox_main" style="float: right;">
	        <span class="proinbox" style="font-size: 38px;">Pro Inbox</span>
	    		<div class="form-group switch_title" style="margin-top: -44px;margin-left: 248px;">
	        <label class="switch">
	          <input type="checkbox" checked>
	          <span class="slider round"></span>
	        </label>
	    </div>
	    </div>
	</div>
</div>
<div class="container">
    <div class="col-md-12 col-xs-12">
        <div class="main-section chat_sec">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 left-sidebar">

                <div class="left-chat leftchatbar">
                    <ul class="left-chat-ul">
                        <?php foreach ($ChatUserData as $userdata) { ?>
                        <?php
							$img = $userdata['image'];
							$temp_file = base_url()."front/images/user.png";
							$main_file = "assets/uploads/profile_image/".$img;
							$filename = FCPATH.$main_file;
							if (file_exists($filename)) {
								if($img != ''){
										$main_image =  base_url().$main_file;
								}else{
										$main_image =  $temp_file;
								}
							}else{
								$main_image =  $temp_file;
							}
                         $class = ($userdata['id'] == $receiverId) ? "active" : ""; ?>
                                <li class="<?php echo $class; ?>" data-sender="<?php echo $senderId; ?>" data-receiver="<?php echo $userdata['id']; ?>" id="chatChange" >
                                    <div class="chat-left-img">
                                        <!-- <span><i class="fa blue" aria-hidden="true"></i></span> -->
                                        <img src="<?=$main_image?>">
                                    </div>
                                    <div class="chat-left-detail">
                                        <p><?php echo $userdata['username']; ?></p>
                                    </div>
                                </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-12 right-sidebar">
                <input type="hidden" name="senderId" id="senderId" value="<?php echo $senderId; ?>">
                <input type="hidden" name="receiverId" id="receiverId" value="<?php echo $receiverId; ?>">
                <?php if(empty($receiverId)){ ?>
                <div class="noConversation">
                    <h3>There are no conversations so far.</h3>
                </div>
							<?php }else{ ?>
                <div class="row">
                    <div class="col-md-12 right-header-contentChat">
                        <ul class="chatsMain">

                          <?php if(!empty($ChatsData)){ ?>
                        	<?php foreach ($ChatsData as $chat) {
								$img = $chat['sender_image'];
								$temp_file = base_url()."front/images/user.png";
								$main_file = "assets/uploads/profile_image/".$img;
								$filename = FCPATH.$main_file;
								if (file_exists($filename)) {
									if($img != ''){
											$main_image =  base_url().$main_file;
									}else{
											$main_image =  $temp_file;
									}
								}else{
									$main_image =  $temp_file;
								}

                        		// if($senderId == $chat['sender_id'])
														// {
														// 	$image = !empty($chat['sender_image']) ? base_url('assets/uploads/profile_image/'.$chat['sender_image']) : base_url('front/images/user.png');
														// }
														// else
														// {
														// 	$image = !empty($chat['sender_image']) ? base_url('assets/uploads/profile_image/'.$chat['sender_image']) : base_url('front/images/user.png');
														// }
							$class = ($senderId == $chat['sender_id']) ? 'rightside-right-chat' : 'rightside-left-chat';
                        	?>
                        	<li>
                                <div class="<?php echo $class; ?>">
                                    <div class="chat-icon-img">
                                        <img src="<?php echo $main_image; ?>">
                                    </div>
                                    <div class="text">
										<p><?php echo $chat['msg']; ?></p>
                                        <!-- <p><?php echo $chat['msg']; ?> <i class="fa fa-smile-o"  style="color: #a5da26;"></i></p> -->
                                    </div>
                                </div>
                            </li>
                        	<?php }
                        	} ?>
                        </ul>
                    </div>
                </div>

                <div class="row messagebar" style="display: none;">
                    <div class="col-md-12 right-chat-textbox">
                        <input type="file" id="imgupload" style="display:none" />
                        <a id="OpenImgUpload"><i class="fa fa-image" aria-hidden="true"></i></a>
                        <input type="text"  placeholder="Message..." id="messageText"><a><i id="send" class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
				<?php } ?>
            </div>
        </div>
    </div>

    </div>
</div>
