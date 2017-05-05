<!-- The element where Fine Uploader will exist. -->
<div id="fine-uploader{{$id}}"></div>
{{--<div id="cameraButtonContainer">Upload from the camera</div>--}}

<!-- Fine Uploader -->
<link href="{{url('libs/fine-uploader/fine-uploader-new.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{url('/libs/fine-uploader/fine-uploader.min.js')}}" type="text/javascript"></script>

<script type="text/template" id="qq-template">
  <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop file here">
    <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container ">
      <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
           class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
    </div>
    <div class="qq-upload-drop-area-selector qq-upload-drop-area " qq-hide-dropzone>
      <span class="qq-upload-drop-area-text-selector"></span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button" style="width: 100%;">
      <div>ファイル選択</div>
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

  var uploader = new qq.FineUploader({
    debug: true,
    element: document.getElementById('fine-uploader{{$id}}'),
    multiple: false,
    request: {
      endpoint: '/bingo/gift/upload',
      params: {
        _token: '{{csrf_token()}}',
        id: "{{$id or ''}}"
      }
    },
    callbacks: {
      onStart: function () {
        console.log('start')
      },
      onComplete: function (id, name, resJ, xhr) {
        console.log(arguments)
      }
    }
  });
</script>