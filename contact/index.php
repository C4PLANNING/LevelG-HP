<?php

define('RECAPTCHA_SITE_KEY', '6LcP69kUAAAAAP4X933FE2nntz4PuRbYRzsZ__i1'); // reCAPTCHAのサイトキー (Google Developer Consoleから取得したものをセットしてください)
define('RECAPTCHA_SECRET_KEY', '6LcP69kUAAAAADWF1uqiKKk0lvMtezPTOqa8-YXT'); // reCAPTCHAのシークレットキー (同上)

/**
 * reCAPTCHA 検証を行います。(単純な検証)
 *
 * @param string $gRecapchaResponse  $_POST['g-recaptcha-response'] 等から取得できるデータ
 * @return array 'success' (成功した場合 true), 'message' (結果メッセージ), 'response' (reCAPTCHA APIからの応答データ(stdClass)) のキーからなる array
 */
function recaptchaSimple($gRecapchaResponse) {
    $success = false; // reCAPTCHA が成功した場合 true, それ以外の場合 false
    $message = ''; // 結果メッセージ
    $response = null; // reCAPTCHA応答データ

    // reCAPTCHAデータあり
    if ($gRecapchaResponse) {
        // reCAPTCHA API用送信データ
        $data = array(
            'secret' => RECAPTCHA_SECRET_KEY,
            'response' => $gRecapchaResponse
        );

        // cURL から応答データを取得 (cURLを使用できない場合は正常に動作しません)
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_POST, true); // POST送信
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&', PHP_QUERY_RFC3986)); // 送信データをセット
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書検証をしない (環境によって動作しない場合があるため)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // curl_exec() 経由で応答データを直接取得できるようにする
        $responseString = curl_exec($curl); // 応答データ取得
        curl_close($curl);

        // 応答取得完了
        if ($responseString !== false) {
            $response = json_decode($responseString, true);
            // JSON解析完了
            if ($response !== false) {
                // reCAPTCHA検証成功
                if (isset($response['success']) && $response['success']) {
                    $success = true;
                    $message = 'reCAPTCHAの検証に成功しました。';
                }
            }
        }
    }

    // 失敗
    if (!$success) {
        $message = 'reCAPTCHAの検証に失敗しました。';
    }

    return compact('success', 'message', 'response');
}
function h($value, $encoding = 'UTF-8') { return htmlspecialchars($value, ENT_QUOTES, $encoding); } // HTMlエスケープ出力用
function eh($value, $encoding = 'UTF-8') { echo h($value, $encoding); } // 同上


// reCAPTCHA 検証 (サンプルフォームを POST にしているため POST 時に検証)
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    $gRecapchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response'); // reCAPTCHAデータ ( $_POST['g-recaptcha-response'] 等でもよいです )
    $result = recaptchaSimple($gRecapchaResponse); // reCAPTCHA 検証
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>株式会社レベル・ジー | 舞台照明プラン／デザイン／オペレート</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="株式会社レベル・ジー | 舞台照明プラン／デザイン／オペレート">

  <meta name="author" content="Themefisher">
  <meta name="generator" content="Hugo 0.59.1" />

  <!-- plugins -->

  <link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css">

  <link rel="stylesheet" href="../plugins/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="../plugins/magnific-popup/magnific-popup.css">

  <link rel="stylesheet" href="../plugins/slick/slick.css">


  <!-- Main Stylesheet -->

  <link rel="stylesheet" href="../scss/style.min.css" media="screen">

  <!--Favicon-->
  <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">

</head>


<body>
  <!-- preloader start -->
  <div class="preloader">

  </div>
  <!-- preloader end -->

  <header class="navigation">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <nav class="navbar">

            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="../">
                <img src="../images/logo.svg" alt="Logo"
                  class="img-responsive">
              </a>
            </div>

            <div class="collapse navbar-collapse" id="navigation">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="../">Home</a></li>



                <li><a href="../about/">About</a></li>



                <li><a href="../business/">Business</a></li>



                <li><a href="../company/">Company</a></li>



                <li><a href="../access/">Access</a></li>



                <li><a href="../contact/" class="current-page">Contact</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <section class="page-title bg-2" style="background-image: url('../images/featue-bg.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block">
            <h1>Contact</h1>
            <p>お問い合わせ</p>
          </div>
        </div>
      </div>
    </div>
  </section>



  <section class="contact-form">
    <div class="container">
      <div class="row">

        <!-- ▼ Lisket メールフォーム簡単作成ツール http://app.lisket.jp/form_maker ここから ▼ -->

        <script src="../plugins/jQuery/jquery.min.js"></script>
        <!-- LocalStorageを利用しページ遷移後もデータを保管 -->
        <script src="../plugins/garlic/garlic.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <form class="lisket-form-maker-form" action="//app.lisket.jp/form_maker/message/12803" method="post" data-persist="garlic">
          <script type="text/javascript" src="//app.lisket.jp/bundles/lisketformmaker/js/form.js"
            charset="utf-8"></script>
          
          
          <div class="col-md-6 col-sm-12">
            <div class="block">
              <div class="form-group">
                <input type="text" id="data_name" name="data[name]" required="required" placeholder="*Name"
                  class="form-control" />
              </div>
              <div class="form-group">
                <input type="email" id="data_mail" name="data[mail]" required="required" placeholder="*Email Address"
                  class="form-control" />
              </div>
              <div class="form-group">
                <input type="text" id="data_field_2" name="data[field_2]" placeholder="Tel" class="form-control" />
              </div>
              <div class="form-group">
                <input type="text" id="data_field_3" name="data[field_3]" required="required" placeholder="*Subject"
                  class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="block">
              <div class="form-group-2">
                <textarea id="data_field_4" name="data[field_4]" required="required" rows="4"
                  placeholder="*Your Message" class="form-control"></textarea>

                <div style="display: none">
                  <input type="hidden" id="data_verification_code" name="data[verification_code]"
                    value="a234f031591001436d04ddff589bdbc251849847" />
                </div>
              </div>
             <!-- 認証チェックのフォームが表示されます -->
              <div class="g-recaptcha" data-callback="clearcall" data-sitekey="<?php eh(RECAPTCHA_SITE_KEY) ?>"></div>
              <br>
              <div class="form-group submit-btn" style="display:none; ">
                <button type="submit" class="btn btn-primary">Send Message</button>
              </div>
              <!-- <div class="form-group">
                <button type="reset" class="btn btn-default">Reset</button>
              </div> -->
            </div>
          </div>
        </form>
      </div>


      <!-- ▲ Lisket メールフォーム簡単作成ツール http://app.lisket.jp/form_maker ここまで ▲ -->

      <div class="h-30"></div>
      <p>*は必須項目です</p>
      <p><a href="../privacy.html" style="text-decoration: underline;">プライバシーポリシー</a>をご確認の上、送信をお願いいたします。</p>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="footer-manu">
            <ul>
              <li><a href="../">Home</a></li>

              <li><a href="../about/">About</a></li>

              <li><a href="../business/">Business</a></li>

              <li><a href="../company/">Company</a></li>

              <li><a href="../access/">Access</a></li>

              <li><a href="../contact/">Contact</a></li>
            </ul>
          </div>
          <p class="copyright">Copyright &copy; LEVEL-G CO.,Ltd All Rights
            Reserved</p>
        </div>
      </div>
    </div>
  </footer>

  
  <script src="../plugins/bootstrap/bootstrap.min.js"></script>

  <script src="../plugins/slick/slick.min.js"></script>

  <script
    src="../plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

  <script src="../plugins/shuffle/shuffle.min.js"></script>

  <script src="../plugins/google-map/gmap.js"></script>

  <script src="../plugins/hero/jquery.easing.min.js"></script>




  <script src="../js/script.min.js"></script>



  <script>
    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date(); a = s.createElement(o),
        m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-156818226-1', 'auto');
    ga('send', 'pageview');
  </script>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script>
    
    //認証にチェックされたら送信ボタンを表示する
    function clearcall(code) {
        if(code !== ""){
            $('.submit-btn').fadeIn();
        }
    }
  </script>
</body>

</html>