/******/ (() => { // webpackBootstrap
  var __webpack_exports__ = {};
  /*!*****************************************************!*\
    !*** ./resources/js/pages/form-file-upload.init.js ***!
    \*****************************************************/
  /******/
  (function () {
    // webpackBootstrap
    var __webpack_exports__ = {};
    /*!*****************************************************!*\
      !*** ./resources/js/pages/form-file-upload.init.js ***!
      \*****************************************************/
  
    /*
    Template Name: Velzon - Admin & Dashboard Template
    Author: Themesbrand
    Website: https://Themesbrand.com/
    Contact: Themesbrand@gmail.com
    File: Form file upload Js File
    */
    // Dropzone
    // var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
    // dropzonePreviewNode.id = "";
    // if (dropzonePreviewNode) {
    //   var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    //   dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    //   var dropzone = new Dropzone(".dropzone", {
    //     url: 'https://httpbin.org/post',
    //     method: "post",
    //     previewTemplate: previewTemplate,
    //     previewsContainer: "#dropzone-preview"
    //   });
    // } // FilePond
  
    FilePond.registerPlugin( // encodes the file as base64 data
    FilePondPluginFileEncode, // validates the size of the file
    FilePondPluginFileValidateSize, // corrects mobile image orientation
    FilePondPluginImageExifOrientation, // previews dropped images
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
  );
    var inputMultipleElements = document.querySelectorAll('input[type="file"].filepond');
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
    if (inputMultipleElements) {
      // loop over input elements
      Array.from(inputMultipleElements).forEach(function (inputElement) {
        // create a FilePond instance at the input element location
        FilePond.create(inputElement).setOptions({
          server: {
            process: '/uploads',
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          },
          allowMultiple: true,
          maxFiles: 3,
          acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'],
          fileValidateTypeLabelExpectedTypesMap: {
              'image/jpeg': '.jpg',
              'image/png': '.png',
              'image/gif': '.gif'
          },
        });
      });
      FilePond.create(document.querySelector('.filepond-input-circle'), {
        labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
        imagePreviewHeight: 170,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom'
      });
    }
    /******/
  
  })();
  /******/ })()
  ;