## Fineuploader GCS Exmple

This repository is an example of how can you upload the files to GCS using fineuploader.


#### Steps to use Fineuploader with GCS

**1) Enable the S3 interoperability feature**

This will allow Fine Uploader to communicate with GCS in the same way it normally talks to S3.

In the Google Cloud admin, navigate to **Cloud Storage > Settings > Interoperability.**
There you can generate the S3-style developer access key (and corresponding secret key) to provide to Fine Uploader.
Note that your access key will start with GOOG.

For more details about this step, see [simple migration](https://cloud.google.com/storage/docs/migrating#migration-simple) in the GCS docs.

**2) Enable CORS for your bucket.**

Without this step, your user's browser will refuse to post information to GCS due to the same-origin security policy.

At the time of this writing, there appeared to be no way to do this step in the Google Cloud admin,
so you need to enable it using either the gsutil command-line tool or with their XML/JSON API.
The steps to take are explained pretty clearly under [Configuring CORS on a Bucket](https://cloud.google.com/storage/docs/cross-origin) in the GCS docs.
Note that the examples in the GCS docs show granting `GET`, `HEAD`, and `DELETE`, while you want to grant `HEAD`, `POST` and `OPTIONS` to enable uploading via Fine Uploader.

 - **To install the gsutil in Ubuntu follow the below steps**
   
   **1) Install the required system packages**
   
      Several packages are required to successfully install gsutil from PyPI. You can install them with the following command:
      
      ```sudo apt-get install gcc python-dev python-setuptools libffi-dev```
      
   **2) Install pip**
   
     We recommend using the pip installer. You can install it with the following command:
     
     ```sudo apt-get install python-pip```
     
   **3) Install gsutil from PyPI**
   
     To install gsutil from PyPI, use the following command:
    
    ```sudo pip install gsutil```
    
 - **Enable the cors using gsutil**
 
    **1) Create the cors.json file**
    
      Create the cors.json file in any location with following configuration.
      ```json
      [
          {
            "origin": ["http://example.appspot.com"],
            "responseHeader": ["Content-Type"],
            "method": ["GET", "HEAD", "DELETE", "POST", "OPTIONS"],
            "maxAgeSeconds": 3600
          }
      ]
      ```
      
    **2) Set the CORS to bucket**
    
      To set the CORS for bucket named `example` use the following command.
      
      ```bash 
      gsutil cors set cors.json gs://example
      ```
      
 **3) Use the normal S3 support in Fine Uploader to upload files to your GCS bucket.**
 
   Now you should be able to take advantage of Fine Uploader's S3 support to upload files to GCS.
   Follow the instructions in the Fine Uploader documentation as if you were using an S3 bucket, except:
    
   - For `endpoint` in the `request` option, use `storage.cloud.google.com` where you see s3.amazonaws.com.
    
   - For `accessKey`, use your GCS-provided access key (starting with `GOOG`) that you created above.
    
   - You still need to implement a `signature` endpoint on your side to sign upload requests, as discussed [here](http://docs.fineuploader.com/branch/master/quickstart/03-setting_up_server-s3.html).
   
     As you get that set up, note that you'll use the GCS-provided access/public key (starting with GOOG) and the corresponding private/secret key in the places where the docs show keys from AWS.