<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile Post Content</title>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
    <div data-role="page" id="post-page">
        <div data-role="header">
            <h1>Post Content</h1>
        </div>

        <div data-role="content">
            <form id="post-form" enctype="multipart/form-data">
                <label for="postContent">Post Content:</label>
                <textarea id="postContent" name="postContent" required></textarea>

                <label for="postImage">Upload Image:</label>
                <input type="file" id="postImage" name="postImage" accept="image/*">

                <label for="imageLink">Image Link:</label>
                <input type="url" id="imageLink" name="imageLink">

                <button type="submit" data-theme="b">Post</button>
            </form>
        </div>

        <div data-role="footer">
            <h4>Powered by jQuery Mobile</h4>
        </div>
    </div>

    <script>

        $(document).on("pagecreate", "#post-page", function () {

            $("#post-form").on("submit", function (e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "submit_post.php", 
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === "success") {

                            alert("Post successfully submitted.");
                        } else {

                            alert("Post successfully submitted.");

                        }
                    },
                    error: function () {

                        alert("Error connecting to the server. Please try again later.");
                    }
                });
            });
        });
    </script>
</body>
</html>