<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <style>
            #notificationContainer {
                background-color: rgba(229, 229, 229, 1);
                width: 400px;
                padding: 10px;
                margin: 10px;
                border-radius: 0px;
                display: none;
                position: relative;
                left: 45%;
                text-align: center;
            }

            .settings-icon-side {
                background-image: url("n.png");
                background-position: -427px -793px;
                width: 30px;
                height: 30px;
                margin-right: 10px;
                transform: scale(1.25, 1.25);
                margin-left: 5px;
            }

            #notificationTriangle {
                width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;
                border-bottom: 10px solid rgba(231, 231, 231, 1);
                position: absolute;
                top: -10px;

                transform: translateX(-50%);
            }

            body {
                font-family: Roboto, sans-serif;
            }

            .rounded-button {
                margin-top: 5px;

                margin-left: 88%;
                display: flex;
                align-items: center;
                background-color: transparent;
                color: white;
                border: none;
                outline: none;
                padding: 0;
                width: 26px;
                height: 26px;
                background-image: url("icon.png");
                background-size: cover;
                border-radius: 50%;
                transition: background-color 0.2s, box-shadow 0.2s;
                box-shadow: none;
                user-select: none;
            }

            .rounded-button:hover,
            .rounded-button:active {
                background-color: transparent;
                box-shadow: none;
            }

            .rounded-button {
                border: none;
                user-select: none;
            }

            .material-icons {
                user-select: none;
            }

            #notificationContainer {
                background-color: rgba(229, 229, 229, 1);
                width: 400px;
                padding: 10px;
                margin: 10px;

                display: none;
                left: 72%;
                text-align: center;
                position: relative;
                transform: translateX(-50%);
                right: 100.953125px;
                top: 109px;
                box-shadow: 0 2px 1px #aaa;
                border-bottom-color: #bbb;
                color: #404040;
                font: 13px Roboto, arial, sans-serif;
            }

        </style>
    </head>
    <body>
        <button id="showNotification" class="btn rounded-button" style="background-color: transparent;">
            <i class="settings-icon-side" style="margin: 0 auto; font-size: 1.5rem; margin-bottom: 0px; font-size: 1.14rem;"></i>
        </button>

        <div id="notificationContainer" style="color: #aaa; max-height: 500px; overflow-y: auto;">
            <span class="title" style="color: #6f6f6f; text-align: center; font-size: 15px;">Loogle notification</span>
            <br />
            <br />
            <div id="mentionsContainer"></div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     
    </body>
</html>
