<!-- The element where Fine Uploader will exist. -->
<div id="fine-uploader"></div>
{{--<div id="cameraButtonContainer">Upload from the camera</div>--}}

<!-- Fine Uploader -->
<script src="{{url('/libs/fine-uploader/fine-uploader.min.js')}}" type="text/javascript"></script>

<script type="text/template" id="qq-template">
  <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container ">
      <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
           class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-drop-area-selector qq-upload-drop-area " qq-hide-dropzone>
      <span class="qq-upload-drop-area-text-selector"></span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button" style="width: 100%;">
      <div>自撮りorファイルを選択</div>
    </div>
    <span class="qq-drop-processing-selector qq-drop-processing ">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
    <ul class="qq-upload-list-selector qq-upload-list " aria-live="polite" aria-relevant="additions removals">
      <li>
        <div class="qq-progress-bar-container-selector">
          <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
               class="qq-progress-bar-selector qq-progress-bar"></div>
        </div>
        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
        <span class="qq-upload-file-selector qq-upload-file"></span>
        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
        <span class="qq-upload-size-selector qq-upload-size"></span>
        <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
        <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
        <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
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
<script>
  var upload_completed = function (id, name, res) {
    //clear invalid message
    document.getElementById("user_photo_validation_message").innerHTML = '';
    var picture = $('#preview_user_photo')
        .attr('src', '')
        .guillotine('remove')
        .unbind();
    $('#loading_img').css('display', 'none');
    $('#confirm_screen_button').unbind('click');
    $('#confirm_screen_button').on('click', function (e) {
      e.preventDefault();
      var cropped_data = picture.guillotine('getData');
      cropped_data.file_name = res.file_name;
      cropped_data.origin_image_url = res.download_url;
      console.log(cropped_data);
      $('#confirm_user_photo_preview').hide();
      $('#confirm_loading_img').show();
      $.post('save_cropped_image', {cropped_data: cropped_data}, function (res) {
        console.log(res);
        $('#confirm_loading_img').hide();
        $('#confirm_user_photo_preview')
            .attr('src', res.editted_image_url)
            .show();
      })
    });

    var camelize = function () {
      var regex = /[\W_]+(.)/g;
      var replacer = function (match, submatch) {
        return submatch.toUpperCase()
      };
      return function (str) {
        return str.replace(regex, replacer)
      }
    }();

    picture.on('load', function () {
      picture.guillotine({
        eventOnChange: 'guillotinechange',
        width: "{{ \App\Http\Controllers\UploadController::IMG_W * 2 }}",
        height: "{{\App\Http\Controllers\UploadController::IMG_H * 2 }}",
      })
      picture.guillotine('fit');

      // Show controls and data
      $('.notice, #controls, #data').removeClass('hidden');

      // Bind actions
      $('#controls a')
          .unbind('click')
          .click(function (e) {
            e.preventDefault();
            var action = camelize(this.id);
            picture.guillotine(action)
          });

      // Update data on change
      picture.on('guillotinechange', function (e, data, action) {
        console.log(action, data);
      })
    });
    console.log(res.download_url);
    picture.attr('src', res.download_url);
  }
  // only show this button in iOS
//  if (!qq.ios()) {
//    document.getElementById("cameraButtonContainer").style.display = "none";
//  }

  var uploader = new qq.FineUploader({
    debug: true,
    element: document.getElementById('fine-uploader'),
    multiple: false,
    request: {
      endpoint: '/saveblob2',
      params: {_token: '{{csrf_token()}}'}
    },
    callbacks: {
      onStart: function () {
        $('#loading_img').css('display', 'block');
      },
      onComplete: function (id, name, resJ, xhr) {
        upload_completed(id, name, resJ)
      }
    },
    {{--camera: {--}}
      {{--ios: {{ (new \Detection\MobileDetect())->isIos() ? 1 : 0 }},--}}
      {{--button: document.getElementById("cameraButtonContainer")--}}
    {{--},--}}
    {{--extraButtons: [--}}
      {{--{--}}
        {{--element: document.getElementById("cameraButtonContainer")--}}
      {{--}--}}
    {{--]--}}
//        deleteFile: {
//            enabled: true,
//            endpoint: '/saveblob2'
//        },
//        retry: {
//            enableAuto: true
//        }
  });
</script>