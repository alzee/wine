let textaera = document.querySelector( '#Node_body' );
if (! textaera) {
  textaera = document.querySelector( '#Product_intro' );
}
ClassicEditor
  .create( textaera, {
    image: {
      upload: {
        types: ['png', 'jpeg']
      }
    },
    simpleUpload: {
      uploadUrl: '/api/media_objects'
      // Enable the XMLHttpRequest.withCredentials property.
      // withCredentials: true,

      // Headers sent along with the XMLHttpRequest to the upload server.
      // headers: {
      //   'X-CSRF-TOKEN': 'CSRF-Token',
      //   Authorization: 'Bearer <JSON Web Token>'
      },
    mediaEmbed: {
      extraProviders: [
        {
          name: 'bilibili',
          // A URL regexp or an array of URL regexps:
          url: /^www\.bilibili\.com\/(\w+)/,

          // To be defined only if the media are previewable:
          // html: match => '...'
        },
      ]
    }
  } )
  .catch( error => {
    console.error( error );
  } );
