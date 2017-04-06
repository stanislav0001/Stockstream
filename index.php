<?php
    $DEVELOPER_KEY = 'YOUTUBE-API';
    $search_part = 'snippet';
    $search_order = 'date';
    $search_type = 'video';
    $search_videoCaption = 'any';
    $search_count = 0;
    $search_items = array();
    $search_q = "Stock stream";
    $search_maxResults = "24";
    $search_sub_string = "";
    $arrSubCategories = array(/*Stock category*/);
    $sub_index = -1;
    
    if (isset($_POST['indexvalue']) && isset($_POST['q']) && isset($_POST['subcategory']))
    {

    //      Call set_include_path() as needed to point to your client library.
    /*      Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the eventType=live
            Google APIs Console <http://code.google.com/apis/console#access>
            Please ensure that you have enabled the YouTube Data API for your project. */
        $idx = (int)$_POST['indexvalue'];
        if ($idx == 0) {
            $search_q = $_POST['q'];
        } else {
            $sub_index = $_POST['subcategory'];
            $search_q = $arrSubCategories[(int)$sub_index][1];
            if ($arrSubCategories[(int)$sub_index][0] == "Live"){
                $search_q="eventType=live";
            }
        }
    }

    $encode_url = "";
    $query_url = "";
    if ($search_q == "eventType=live")
    {
        $encode_url = urlencode("stock market");
        $query_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q='.$encode_url.'&maxResults='.$search_maxResults.'&type=video&eventType=live&key=AIzaSyDXKJZfwKDzbJP4zQONU-y_hCJVlElsRFw';
    } else {
        $encode_url = urlencode($search_q);
        $query_url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&order=date&q='.$encode_url.'&maxResults='.$search_maxResults.'&type=video&videoCaption=any&key=AIzaSyDXKJZfwKDzbJP4zQONU-y_hCJVlElsRFw';
    }
    if (isset($_POST['pagetoken']))
    {
        if (strlen($_POST['pagetoken']) > 0)
        {
            $query_url.= "&pageToken=".$_POST['pagetoken'];
        }
    }
    $json_array = file_get_contents($query_url);
    $search_results = json_decode($json_array);
    $search_items = $search_results->items;
    $search_count = count($search_items);
    $prev_flag = "";
    $next_flag = "";

    if (isset($search_results->prevPageToken))
        $prev_flag = $search_results->prevPageToken;

    if (isset($search_results->nextPageToken))
        $next_flag = $search_results->nextPageToken;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="YoutubeSearch">

    <meta name="author" content="David Zhang">
    <title>Services | Youtube Search</title>
    
    <!-- core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/thumbnail-gallery.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<style type="text/css">
.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    position: relative;
    min-height: 1px;
    padding-right: 2px;
    padding-left: 2px;
    padding-top: 2px;
    padding-bottom: 2px;
}

.container img {
    width: 100%;
    height: 100%;
    position: relative;
}

.advertisment{
    background-color: #EEE;
    height: 100px;

}


}

.btn1 {
    padding: 14px 24px;
    border: 0 none;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}
 
.btn1:focus, .btn1:active:focus, .btn1.active:focus {
    outline: 0 none;
}
 
.btn-primary {
    background: #0099cc;
    color: #ffffff;
}
 
.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary {
    background: #33a6cc;
}
 
.btn-primary:active, .btn-primary.active {
    background: #007299;
    box-shadow: none;
}

.btn1.outline {
    background: none;
    padding: 12px 22px;
}

.btn-primary.outline {
    border: 2px solid #0099cc;
    color: #0099cc;
}

.btn-primary.outline:hover, .btn-primary.outline:focus, .btn-primary.outline:active, .btn-primary.outline.active, .open > .dropdown-toggle.btn-primary {
    color: #33a6cc;
    border-color: #33a6cc;
}

.btn-primary.outline:active, .btn-primary.outline.active {
    border-color: #007299;
    color: #007299;
    box-shadow: none;
}

body{
    padding-top: 30px;
    background: #f8f8f8;
    padding-bottom: 50px;
}

.carousel-caption{
    font-size: 13px;
    background-color:rgba(0, 0, 0, 0.5);
    width:100%;
    text-align: center;
    margin-left:
    padding-left: 0;
    right: 0%;
    left: 0%;
    bottom:0%;
    text-shadow: none;
    padding-top: 0px;
	padding-bottom: 0px;
}

</style>

<script type="text/javascript">
    function change_item(id, img_url, video_url, title)
    {
        if (document.getElementById("pre_index").value != "") {
            var ix = document.getElementById("pre_index").value;
            var pre_img_url = document.getElementById("pre_img_url").value;
            var pre_video_url = document.getElementById("pre_video_url").value;
            var pre_title = document.getElementById("pre_title").value;
            var pre_div_name = "video_tiles_"+document.getElementById("pre_index").value;
            var pre_hContent = "<div class=\"col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb\"><div class=\"carousel-inner\"><img class=\"img-responsive\" src=\""+pre_img_url + "\" onclick=\"change_item(\''+ix+'\', \''+pre_img_url+'\', \''+pre_video_url+'\');\"></img><div class=\"carousel-caption\">"+pre_title+"</div></div></div>";
            document.getElementById(pre_div_name).innerHTML = pre_hContent;
        }

        var div_name = "video_tiles_"+id;
        var first_div = '<div class=\'col-lg-12 col-md-12 col-sm-12 col-xs-12 thumb\'><div class=\'col-lg-9 col-md-8 col-sm-8 col-xs-12 thumb\'>';
        var second_div = '<div class=\'embed-responsive embed-responsive-16by9 vid\'>';
        var third_iframe = '<iframe class=\'embed-responsive-item\' src=';
        var v_url = '\'' + video_url + '\'';
        var hContent = first_div + second_div + third_iframe + v_url + " allowfullscreen></iframe></div></div><div class=\'col-lg-3 col-md-4 col-sm-4 col-xs-12 advertisment\'><h2>Avdertisment</h2></div></div>";
        document.getElementById(div_name).innerHTML = hContent;
        document.getElementById("pre_index").value = id;
        document.getElementById("pre_img_url").value = img_url;
        document.getElementById("pre_video_url").value = video_url;
        document.getElementById("pre_title").value = title;
    }

    function setCategory(subcategory)
    {
        document.getElementById("subcategory").value = subcategory;
        document.getElementById("indexvalue").value = "1";
        document.getElementById("q").value = "";
        document.getElementById("myform").submit();
    }

    function setNext()
    {
        document.getElementById("pagetoken").value = "<?php echo $next_flag; ?>";
<?php
if ($sub_index >= 0) {
?>
        document.getElementById("subcategory").value = "<?php echo $sub_index; ?>";
<?php
}
?>
        document.getElementById("myform").submit();
    }

    function setPrev()
    {
        document.getElementById("pagetoken").value = "<?php echo $prev_flag; ?>";
<?php
if ($sub_index >= 0) {
?>
        document.getElementById("subcategory").value = "<?php echo $sub_index; ?>";
<?php
}
?>
        document.getElementById("myform").submit();
    }
</script>
<body>
    <section id="feature" class="transparent-bg">
        <div class="container">
            <form id="myform" method="POST" action="">
                <div class="row" style="padding-left:20px;padding-right:20px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:right;">
                        <div>
                            <img class="logoimg" src="logo.png" style="width:315px;height:80px;"></img>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="q" name="q" placeholder="AAPL..." value="<?php if (isset($_POST['q'])){echo $_POST['q'];}?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" style="margin:0px;">Search</button>
                            </span>
                        </div>

                        <input type="hidden" id="maxResult" name="maxResults" value="24" />
                        <input type="hidden" id="subcategory" name="subcategory" value="<?php if (isset($_POST['subcategory'])){echo $_POST['subcategory'];} ?>" />
                        <input type="hidden" id="pagetoken" name="pagetoken" value="" />
                        <input type="hidden" id="indexvalue" name="indexvalue" value="0" />
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="text-align:center;">
    <?php
                    for ($i = 0 ; $i < sizeof($arrSubCategories) ; $i++) {
                        if (isset($_POST['subcategory']) && $i==(int)$_POST['subcategory']){
    ?>
                        <input type="button" class="btn btn-success" value="<?php echo $arrSubCategories[$i][0];?>" onclick="setCategory('<?php echo $i;?>')"></input>
    <?php
                        }
                        else
                        {
    ?>
                        <input type="button" class="btn btn-default" value="<?php echo $arrSubCategories[$i][0];?>" onclick="setCategory('<?php echo $i;?>')"></input>
    <?php
                        }
                    }
    ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:left;padding-top:20px;">
                        <font  face="muli" color="black" size="4">Stock Market Videos. Sorted by Date.</font>
                    </div>
                </div>
                <div id="ysvideo">
        <?php
                    for ($i = 0 ; $i < $search_count ; $i++) {
                        $search_data = $search_items[$i];
                        $s_snippet = $search_data->snippet;
                        $s_title = $s_snippet->title;
                        $s_thumbnail = $s_snippet->thumbnails;
                        $default_thumbnail = $s_thumbnail->default;
                        $medium_thumbnail = $s_thumbnail->medium;
                        $high_thumbnail = $s_thumbnail->high;
                        $image_url = '';
                        if (isset($high_thumbnail)) {
                            $image_url = $high_thumbnail->url;
                        } elseif (isset($medium_thumbnail)) {
                            $image_url = $medium_thumbnail->url;
                        } elseif (isset($default_thumbnail)) {
                            $image_url = $high_thumbnail->url;
                        } else {
                            $image_url = 'http://placehold.it/400x300';
                        }
                        $video_url = "//www.youtube.com/embed/".$search_data->id->videoId."?autoplay=1";
        ?>
                        <div id="video_tiles_<?php echo $i;?>">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb">
                                <div class="carousel-inner">
                                    <img class="img-responsive" src='<?php echo $image_url;?>' onclick="change_item('<?php echo $i;?>', '<?php echo $image_url;?>', '<?php echo $video_url;?>', '<?php echo $s_title;?>');" height="100px">
                                    </img>
                                    <div class="carousel-caption">
                                        <?php echo $s_title;?>
                                    </div>
                                </div>
                            </div>
                        </div>
        <?php
                    }
        ?>
                    <input type="hidden" id="pre_index" name="ix" value="">
                    <input type="hidden" id="pre_img_url" name="pre_img_url" value="">
                    <input type="hidden" id="pre_video_url" name="pre_video_url" value="">
                    <input type="hidden" id="pre_title" name="pre_title" value="">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 20px;padding-right: 20px;padding-top: 30px;"> 
        <?php
                        if (strlen($prev_flag) > 0) {
        ?>
                        <input type="button" class="btn1 btn-primary outline" value="◁Prev" style="float: left;" onclick="setPrev()"></input>
        <?php
                        }
                        if (strlen($next_flag) > 0) {
        ?>
                        <input type="button" class="btn1 btn-primary outline" value="Next▷" style="float: right;" onclick="setNext()"></input>
        <?php
                        }
        ?>
                    </div>
                </div>
            </form>
        </div><!--/.container-->
    </section><!--/#feature-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>