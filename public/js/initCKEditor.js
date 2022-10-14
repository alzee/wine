ClassicEditor
  .create( document.querySelector( '#Node_body' ), {
    simpleUpload: {
      uploadUrl: '/api/media_objects'
      // Enable the XMLHttpRequest.withCredentials property.
      // withCredentials: true,

      // Headers sent along with the XMLHttpRequest to the upload server.
      // headers: {
      //   'X-CSRF-TOKEN': 'CSRF-Token',
      //   Authorization: 'Bearer <JSON Web Token>'
      }
    } )
  .catch( error => {
    console.error( error );
  } );
