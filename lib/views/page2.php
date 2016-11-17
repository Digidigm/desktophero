
<div class='bbcontainer'>
	<?php $form = array(
            'key'                       => 'FILENAME.png',
            'AWSAccessKeyId'            => 'AKIAILPAAMGAY7QOWT7Q',
            'acl'                       => 'public-read',
            'success_action_redirect'   => '',
        );

        $form['policy'] = '{
            "expiration": "2016-12-01T12:00:00.000Z",
                "conditions": [
                    {
                        "acl": "'.$form['acl'].'"
                    },
                    {
                        "success_action_redirect": "'.$form['success_action_redirect'].'"
                    },
                    {
                        "bucket": "desktop-hero"
                    },
                    [
                        "starts-with",
                        "$key",
                        ""
                    ]
                ]
            }';

    $form['policy_encoded'] = base64_encode($form['policy']);
    $form['signature'] = base64_encode(hash_hmac( 'sha1', base64_encode(utf8_encode($form['policy'])), 'HkGQmX7GVrvCRgMrE89q5oZiafEPF1g3tbO7GHPx', true));

?>


<form action="https://desktop-hero.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
 	  <input type="hidden" name="Content-Type" value="image/">
      <input type="hidden" name="key" value="<?php echo $form['key'] ?>">
      <input type="hidden" name="AWSAccessKeyId" value="<?php echo $form['AWSAccessKeyId'] ?>">
      <input type="hidden" name="acl" value="<?php echo $form['acl'] ?>">
      <input type="hidden" name="success_action_redirect" value="<?php echo $form['success_action_redirect'] ?>">
      <input type="hidden" name="policy" value="<?php echo $form['policy_encoded'] ?>">
      <input type="hidden" name="signature" value="<?php echo $form['signature'] ?>">

      File to upload to S3:
      <input name="file" type="file">
      <br>
      <input type="submit" value="Upload File to S3">
</form>
</div>

<img src='http://desktop-hero.s3.amazonaws.com/FILENAME.png'>

<style>
.bbcontainer {padding: 100px;}
</style>