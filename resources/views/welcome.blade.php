<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fineuploader GCP Example</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{secure_asset('css/fine-uploader-gallery.css')}}" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #fine-uploader-gallery {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class="position-ref full-height">
            <div class="content">
                <h1>Fineuploader Example with GCS</h1>
            </div>
            <div id="fine-uploader-gallery">

            </div>
        </div>

        <script type="text/template" id="qq-template">
            <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
                <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
                </div>
                <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                    <span class="qq-upload-drop-area-text-selector"></span>
                </div>
                <div class="qq-upload-button-selector qq-upload-button">
                    <div>Upload a file</div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
            <span>Processing dropped files...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
                <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                    <li>
                        <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                        <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                        </div>
                        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                        <div class="qq-thumbnail-wrapper">
                            <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                        </div>
                        <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                        <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                            <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                            Retry
                        </button>

                        <div class="qq-file-info">
                            <div class="qq-file-name">
                                <span class="qq-upload-file-selector qq-upload-file"></span>
                                <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                            </div>
                            <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                            <span class="qq-upload-size-selector qq-upload-size"></span>
                            <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                                <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                            </button>
                            <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                                <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                            </button>
                            <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                                <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                            </button>
                        </div>
                    </li>
                </ul>

                <dialog class="qq-alert-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Close</button>
                    </div>
                </dialog>

                <dialog class="qq-confirm-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">No</button>
                        <button type="button" class="qq-ok-button-selector">Yes</button>
                    </div>
                </dialog>

                <dialog class="qq-prompt-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <input type="text">
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Cancel</button>
                        <button type="button" class="qq-ok-button-selector">Ok</button>
                    </div>
                </dialog>
            </div>
        </script>

        <script type="text/javascript" src="{{ secure_asset('js/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ secure_asset('js/s3.jquery.fine-uploader.js') }}"></script>

        <script>
            var uploader = new qq.s3.FineUploader({
                debug: true,
                element: document.getElementById('fine-uploader-gallery'),
                request: {
                    endpoint: 'https://storage.googleapis.com/fineuploader-test.appspot.com',
                    accessKey: 'GOOGKZ5UYT2Q33IYBYYD'
                },
                objectProperties:{
                    bucket:'fineuploader-test.appspot.com',
                    host:'https://storage.googleapis.com/fineuploader-test.appspot.com',
                },
                signature: {
                    endpoint: '/gcp/endpoint'
                },
                uploadSuccess: {
                    endpoint: '/gcp/endpoint?success=true&rand='
                },
                iframeSupport: {
                    localBlankPagePath: '/success.html'
                },
                retry: {
                    enableAuto: true // defaults to false
                },
                deleteFile: {
                    enabled: true,
                    endpoint: '/gcp/endpoint?delete'
                },
                cors: {
                    //all requests are expected to be cross-domain requests
                    expected: true,

                    //if you want cookies to be sent along with the request
                    sendCredentials: true
                },
                callbacks: {
                    onComplete : function(id, name, response, xhr){
                        console.log(id, name, response, xhr);
                        var input = document.createElement('INPUT');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('name', 'images[]');
                        input.setAttribute('value', response.key);
                        console.log(input);
                        $('#ff').append(input);
                    },
                    onDeleteComplete :  function(id, xhr, isError){
                        console.log(id, xhr, isError);
                        var response = JSON.parse(xhr.response);
                        console.log(response, response.key);
                        $(':input[value="'+response.key+'"]').remove();
                    }
                }
            });
        </script>
    </body>
</html>
