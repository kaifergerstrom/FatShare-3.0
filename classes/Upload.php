<?php
class Upload {

	public function CreateUploadForm() {
        global $user;
		?>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div class='upload-form-container'>
				<div class='upload-option-block'>
                    <img class='profile-img-upload-form' src='assets/profile_img/<?php echo $user::$profile_img;?>'>
				    <textarea name='post_desc' class='upload-form-textarea' placeholder="What's new?"></textarea>
                    <div class='upload-form-file-block'>
                        <input type="file" class='inputfile' name="fileToUpload" id="fileToUpload">
                        <label for="fileToUpload" id='inputfilelabel' class='choose-file-btn'>Attach a file</label>
                        <button type='button' class='remove-image-post' id='remove-img-post'><i class="fas fa-times"></i></button>
				        <button type="submit" name="submit_upload" class='post-upload-btn'>Post</button>
                    </div>
                    <img id="blah" class='post-preview-img' src="#" alt="your image" />
				</div>
			</div>
		</form>

		<?php
	}

}