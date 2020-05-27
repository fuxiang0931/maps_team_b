<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Map画面</title>
        <link rel="stylesheet" href="../css/main_style.css" type="text/css" />
    </head>
    <body>
        <header>
            <div class="header_box">
                <a href="">
                    <img class="logo" src="../web_image/logo.png"></img>
                </a>
                <div class="header_menu">ユーザー：<?php print $user_name; ?></div>
                <div class="header_menu header_spe"><a class="header_link" href="logout.php">ログアウト</a></div>
                <div class="header_menu header_spe"><a class="header_link" href="">Menu</a></div>
                <div class="header_menu header_spe"><a class="header_link" href="like.php">気になる</a></div>
                <div class="header_menu header_spe"><a class="header_link" href="search.php">TOP</a></div>
            </div>
        </header>
        <section class="content">
<?php       foreach ($errors as $error) { ?>
            <p><?php print $error; ?></p>
<?php       } ?>
        　　<div id="map_page_map_box"></div>
<?php   if($spots !== []){ ?>
            <h3 id="map_h3"><?php print $spots[0]['anime_name'] . "聖地リスト" ;?></h3>
            <div class="list_scroll"><table class="map_page_table">
                <tr>
                    <th>No</th>
                    <th>場所</th>
                    <th>シーン</th>
                    <th>スポット画像</th>
                    <th>営業施設</th>
                    <th>施設画像</th>
                    <th>営業時間</th>
                    <th>価格</th>
                    <th>営業内容</th>
                    <th>気になる</th>
                </tr>
<?php           foreach ($spots as $spot){ ?>
                <tr>
                    <form method="post" action="map.php">
                        <input type="hidden" name="anime_id" value="<?php print $anime_id; ?>"/>
                        <td><div class="map_page_location_id"><?php print entity_str($spot['location_id']); ?></div></td>
                        <td><div class="map_page_spot_name"><?php print entity_str($spot['spot_name']); ?></div></td>
                        <td class="map_page_table_td"><div class="map_page_table_text"><?php print entity_str($spot['spot_content']); ?></div></td>
                        <td><img class="map_page_img" src="<?php print entity_str($spot['spot_image']); ?>" alt="spot_image"></td>
                        <td><div class="map_page_spot_name"><?php print entity_str($spot['business_name']); ?></div></td>
                        <td><img class="map_page_img" src="<?php print entity_str($spot['business_image']); ?>" alt="business_image"></td>
                        <td class="map_page_table_td"><?php print entity_str($spot['business_time']); ?></td>
                        <td><?php print entity_str($spot['price']); ?></td>
                        <td class="map_page_table_td"><div class="map_page_table_text"><?php print entity_str($spot['business_content']); ?></div></td>
                        <td class="map_page_table_td">
                            <button id="like" type ="submit" name="like_spot_id" value="<?php print entity_str($spot['spot_id']); ?>" >気になる登録</button>
                        </td>
                    </form>
                </tr>
<?php   } ?>
            </table></div>
<?php       } ?>
            <div id="popup_layer"></div>
            <div id="map_page_popup">
                <div>気になる登録しました！</div>
                <input type="button" id="popup_close" value="閉じる">
            </div>
            <div class="return_div"><a class="return_link" href="search.php">検索画面に戻る</a></div>
        </section>
        <script>
            var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var labelIndex = 0;
            var map_spot;
            var map;
            var markers = [];
            function initMap(){
                map_spot = JSON.parse('<?php echo $spots_json; ?>');
                console.log('hello');
                
                var map_box = document.getElementById('map_page_map_box');
                var mapCenter = {
                  lat: parseFloat(map_spot[0]['lat']),
                  lng: parseFloat(map_spot[0]['lng'])
                };
                map = new google.maps.Map(
                  map_box,
                  {
                    center: mapCenter,
                    zoom: 12,
                    disableDefaultUI: true,
                    zoomControl: true,
                    clickableIcons: false,
                  }
                );
                
                if(map_spot.length>0){
                    addMaker();
                }
            }
              
            function addMaker(){
                // console.log(like_spot);
                map_spot.forEach(function(value){
                    var lat = parseFloat(value['lat']);
                    var lng = parseFloat(value['lng']);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: {lat:lat,lng:lng},
                        label: labels[labelIndex++ % labels.length]
                    });
                    markers.push(marker);
                });
            }

            $(function(e){
                //気になるボタンクリック時にポップアップ表示
                $("#like").click(function(e){
                    $("#map_page_popup, #popup_layer").show();
                });
                //ポップアップの閉じるボタンクリック時の処理
                $("#popup_close, #pop_up_layer").click(function(){
                    $("#popup_close, #popup_layer").hide();
                });
            });
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=<?php echo API_KEY; ?>&callback=initMap"></script>
        <footer>
        <section class="foot_all">
            <p style="text-align:center"><a class="foot_link" href="question.php">お問い合わせ</a></p>
            <p class="footer_img"><img src="../web_image/team_logo.png"></img></p>
            <p style="text-align:center;color:black;font-size:10px"><small>Copyright &copy; B-Team All Rights Reserved.</small></p>
        </section>
        </footer>
    </body>
</html>
