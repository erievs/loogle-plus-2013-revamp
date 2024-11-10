<button type="button" class="modal-trigger post-button" data-target="write-post-modal"><i class="material-icons">create</i></button>

<div id="write-post-modal" class="modal">
    <div class="modal-content">
        <p class="modal-username"><?php echo $_SESSION['username']; ?></p>
        <form id="write-post-form" enctype="multipart/form-data" method="post" action="submit_post.php">
            <textarea id="postContent" class="materialize-textarea post-input" name="postContent" placeholder="Write something..."></textarea>
            <div class="image-link-container">
                <div class="modal-action icon-button">
                    <label for="imageUpload" class="material-icons upload-icon">insert_photo</label>
                    <input type="file" id="imageUpload" name="postImage" accept="image/*" style="display: none;">
                    <i class="material-icons" id="openLinkModal">insert_link</i>
                </div>
            </div>
            <div class="modal-buttons">

                <button type="button" class="modal-action modal-close btn-flat">Cancel</button>
                <button type="submit" class="modal-action btn-flat">Post</button>
            </div>
        </form>
    </div>
</div>
<div id="linkModal" class="modal">
    <div class="modal-content">
        <h6>Insert Link</h6>
        <input type="text" id="insertLinkInput" placeholder="Paste your link here">
    </div>
    <div class="modal-footer">
        <button id="cancelLinkButton" class="modal-close btn-flat">Cancel</button>
        <button id="insertLinkButton" class="btn-flat">Insert</button>
    </div>
</div>