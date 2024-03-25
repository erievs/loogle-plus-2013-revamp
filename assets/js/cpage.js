// script.js

document.addEventListener('DOMContentLoaded', function() {
    var dropdownElems = document.querySelectorAll('.dropdown-trigger');
    var options = {
        inDuration: 300,
        outDuration: 225,
        hover: false,
        coverTrigger: false,
        alignment: 'left',
        closeOnClick: true
    };
    M.Dropdown.init(dropdownElems, options);

    dropdownElems.forEach(function(dropdownElem) {
        dropdownElem.addEventListener('click', function(event) {
            event.preventDefault();
            var instance = M.Dropdown.getInstance(dropdownElem);
            instance.open();
        });
    });

    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);



    var postInput = document.getElementById('postContent');
    var writePostModal = M.Modal.init(document.getElementById('write-post-modal'), {});

    postInput.addEventListener('click', function() {
        writePostModal.open();
    });

    var editCommunityModal = M.Modal.init(document.getElementById('editCommunityModal'), {});
    var editCommunityForm = document.getElementById('editCommunityForm');
    var saveCommunityChanges = document.getElementById('saveCommunityChanges');

    document.getElementById('editCommunityButton').addEventListener('click', function() {
        document.getElementById('communityName').value = "<?php echo $communityName; ?>";
        document.getElementById('communityDescription').value = "<?php echo $communityDescription; ?>";
    });

    saveCommunityChanges.addEventListener('click', function() {
        saveCommunityChanges.disabled = true;

        var editedName = document.getElementById('communityName').value;
        var editedDescription = document.getElementById('communityDescription').value;

        var formData = new FormData();
        formData.append('communityName', editedName);
        formData.append('communityDescription', editedDescription);

        var communityImage = document.getElementById('communityImage').files[0];
        if (communityImage) {
            formData.append('communityImage', communityImage);
        }

        $.ajax({
            url: 'update_community.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Community information updated successfully.');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error updating community information:', error);
            }
        });
    });

    var titleElement = document.querySelector('h1.c-name');
    var titleLines = titleElement.offsetHeight / parseFloat(getComputedStyle(titleElement).lineHeight);
    var marginTop = 500 - (titleLines - 1) * 100;
    document.querySelector('.container').style.marginTop = marginTop + 'px';

    var writePostModal = M.Modal.init(document.getElementById('write-post-modal'), {});
    var linkModal = document.getElementById('linkModal');
    var openLinkModal = document.getElementById('openLinkModal');
    var cancelLinkButton = document.getElementById('cancelLinkButton');
    var insertLinkInput = document.getElementById('insertLinkInput');
    var insertLinkButton = document.getElementById('insertLinkButton');

    var communityName = writePostModal.el.getAttribute('data-communityname');

    openLinkModal.addEventListener('click', () => {
        document.getElementById('communityNameInput').value = communityName;
        var linkModalInstance = M.Modal.init(linkModal);
        linkModalInstance.open();
    });

    cancelLinkButton.addEventListener('click', () => {
        linkModalInstance.close();
        insertLinkInput.value = '';
    });

    insertLinkButton.addEventListener('click', () => {
        document.getElementsByName('postLink')[0].value = insertLinkInput.value;
        linkModalInstance.close();
        insertLinkInput.value = '';
    });
});
