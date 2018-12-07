export default {
    limitImageSize(datas, maxWidth) {
        return new Promise(async function (resolve) { //, reject) {

            // We create an image to receive the Data URI
            var img = document.createElement('img');

            // When the event "onload" is triggered we can resize the image.
            img.onload = function () {
                img.src=datas;

                if (img.width<=maxWidth) 
                {
                    //console.log('image not resized');
                    resolve(datas);
                }
                else
                {
                let wantedHeight = Math.round(maxWidth * img.height / img.width);
                //console.log(img);
                // We create a canvas and get its context.
                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext('2d');

                // We set the dimensions at the wanted size.
                canvas.width = maxWidth;
                canvas.height = wantedHeight;

                // We resize the image with the canvas method drawImage();
                ctx.drawImage(this, 0, 0, maxWidth, wantedHeight);

                let dataURI = canvas.toDataURL();

                //console.log('image size: '+img.width+"->"+maxWidth)
                // This is the return of the Promise
                resolve(dataURI);
                }
            };

            // We put the Data URI in the image's src attribute
            img.src = datas;

        })
    },


    // Takes a data URI and returns the Data URI corresponding to the resized image at the wanted size.
    resizedataURL(datas, wantedWidth, wantedHeight) {
        return new Promise(async function (resolve) { //, reject) {

            // We create an image to receive the Data URI
            var img = document.createElement('img');

            // When the event "onload" is triggered we can resize the image.
            img.onload = function () {
                //img.src=datas;
                //if (wantedHeight == 0) wantedHeight = Math.round(wantedWidth * img.height / img.width);
                //console.log(img);
                // We create a canvas and get its context.
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                // We set the dimensions at the wanted size.
                canvas.width = wantedWidth;
                canvas.height = wantedHeight;

                // We resize the image with the canvas method drawImage();
                ctx.drawImage(this, 0, 0, wantedWidth, wantedHeight);

                var dataURI = canvas.toDataURL();

                // This is the return of the Promise
                resolve(dataURI);
            };

            // We put the Data URI in the image's src attribute
            img.src = datas;

        })
    }// Use it like : var newDataURI = await resizedataURL('yourDataURIHere', 50, 50);

}