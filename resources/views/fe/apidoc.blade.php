@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Domain; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Tài Liệu API
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">API</li>
                <li class="breadcrumb-item text-gray-500">Document</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="py-5">
            <h1 class="anchor fw-bold mb-5" id="basic" data-kt-scroll-offset="50">
                <a href=""></a>               
                API Whois Domain</h1>
            <div class="highlight">
                <div class="highlight-code">
                    <pre class="language-php">
                        <code>
                    GET {{ route('api.whois') }}?domain=muabanwebsite.io.vn
                        </code>
                    </pre>
                    <pre class="language-html" tabindex="0">
                        <code class="language-php">                               
                                <span class="token tag">
                                    <span class="token string double-quoted-string"></span>{
                                        "DNSSEC": "unsigned",
                                        "code": "0",
                                        "createdDate": "2024-12-05T14:41:10.865047",
                                        "creationDate": "29-08-2023",
                                        "creationDate_L": 1693316866000,
                                        "domainName": "muabanwebsite.io.vn",
                                        "expirationDate": "29-08-2026",
                                        "expirationDate_L": 1788011266000,
                                        "nameServer": [
                                            "kimora.ns.cloudflare.com",
                                            "morgan.ns.cloudflare.com"
                                        ],
                                        "registrar": "COSMOTOWN, INC.",
                                        "status": [
                                            "clientDeleteProhibited",
                                            "clientRenewProhibited",
                                            "clientTransferProhibited",
                                            "clientUpdateProhibited"
                                        ],
                                        "message": "Đã được đăng ký"
                                    }</span> 
                            </code>
                         </pre>
                    </div>
              </div>
        </div>
        <div class="py-5">
            <h1 class="anchor fw-bold mb-5" id="basic" data-kt-scroll-offset="50">
                <a href=""></a>               
                API Find ID Facebook</h1>
            <div class="highlight">
                <div class="highlight-code">
                    <pre class="language-php">
                        <code>
                    GET {{ route('api.infofb') }}?uidfb=https://www.facebook.com/muabanwebsite
                        </code>
                    </pre>
                    <pre class="language-html" tabindex="0">
                        <code class="language-php">                               
                                <span class="token tag">
                                    <span class="token string double-quoted-string"></span>{
                                        "data": {
                                            "id": "100058502926153",
                                            "name": null,
                                            "from": "thiry-party-et2"
                                        },
                                        "status": 200,
                                        "message": "Lấy UID thành công"
                                    }</span> 
                            </code>
                         </pre>
                    </div>
              </div>
        </div>
        <div class="py-5">
            <h1 class="anchor fw-bold mb-5" id="basic" data-kt-scroll-offset="50">
                <a href=""></a>               
                API TikTok</h1>
            <div class="highlight">
                <div class="highlight-code">
                    <pre class="language-php">
                        <code>
                    GET {{ route('api.tiktok') }}?link=https://vt.tiktok.com/ZSjGGatGL
                        </code>
                    </pre>
                    <pre class="language-html" tabindex="0">
                        <code class="language-php">                               
                                <span class="token tag">
                                    <span class="token string double-quoted-string"></span>{
                                        "code": 0,
                                        "msg": "success",
                                        "processed_time": 0.4776,
                                        "data": {
                                            "id": "7442660130044267794",
                                            "region": "VN",
                                            "title": "Nh\u1ea1c cute z\u1eef tr\u1eddi.. #hongquang02 #promisedaxix ",
                                            "cover": "https:\/\/p16-sign-sg.tiktokcdn.com\/tos-alisg-p-0037\/osGGidoFeHfIRiLGpYQDltAwcRAe6l1TcSJQfG~tplv-tiktokx-cropcenter:300:400.jpeg?dr=14579&nonce=17113&refresh_token=132288e90d38d10cce03679dbb116ca5&x-expires=1733580000&x-signature=n26nRUI6fns9yHKWiumCi0JRmcY%3D&idc=maliva&ps=13740610&s=AWEME_DETAIL&shcp=34ff8df6&shp=d05b14bd&t=4d5b0474",
                                            "ai_dynamic_cover": "https:\/\/p16-sign-sg.tiktokcdn.com\/tos-alisg-p-0037\/ok4TlxAJeAgrIfiIBGGdMfF0RIGwLRvO8ofgU1~tplv-tiktokx-origin.image?dr=14575&nonce=58379&refresh_token=32de9a111d5ba2d211cad5aad6772bc5&x-expires=1733580000&x-signature=ZnzFGTTuXrsjhkyW9ADmFIVoyIQ%3D&idc=maliva&ps=13740610&s=AWEME_DETAIL&shcp=34ff8df6&shp=d05b14bd&t=4d5b0474",
                                            "origin_cover": "https:\/\/p16-sign-sg.tiktokcdn.com\/tos-alisg-p-0037\/o46IcRHfQe1RwPJFYTsGeG6GflALA1oAx60dQG~tplv-tiktokx-360p.jpeg?dr=14555&nonce=16383&refresh_token=efdd3ec7ab6417cb9b38979e5cf17396&x-expires=1733580000&x-signature=cGhCORtWShbm6krTBslj66565v4%3D&ftpl=1&idc=maliva&ps=13740610&s=AWEME_DETAIL&shcp=34ff8df6&shp=d05b14bd&t=4d5b0474",
                                            "duration": 33,
                                            "play": "https:\/\/v16m-default.akamaized.net\/b66269441f538b43f6b1095c2c6578bd\/6753650e\/video\/tos\/alisg\/tos-alisg-pve-0037c001\/oIJA0FIoffGHGWAxf8pOL2mGe1wA0dRRj4glMw\/?a=0&bti=OUBzOTg7QGo6OjZAL3AjLTAzYCMxNDNg&ch=0&cr=0&dr=0&er=0&lr=all&net=0&cd=0%7C0%7C0%7C0&cv=1&br=946&bt=473&cs=0&ds=6&ft=XE5bCqT0majPD12WNooJ3wUOx5EcMeF~O5&mime_type=video_mp4&qs=0&rc=aGdlNjo1ODs5PDlnaDhoaEBpamZyanc5cnZ0dzMzODczNEBeX2JeNmA2Ni8xYzYuLWM2YSNiNG1jMmRrNDFgLS1kMWBzcw%3D%3D&vvpl=1&l=2024120614561283F7906C54C46711091A&btag=e00088000",
                                            "wmplay": "https:\/\/v16m-default.akamaized.net\/8c338b2febf574da6c5ade61e049d235\/6753650e\/video\/tos\/alisg\/tos-alisg-pve-0037c001\/oIZEDlFSsIDXy6QAPdDgfDEfnJEGRYOBcCAapB\/?a=0&bti=OUBzOTg7QGo6OjZAL3AjLTAzYCMxNDNg&ch=0&cr=0&dr=0&er=0&lr=all&net=0&cd=0%7C0%7C0%7C0&cv=1&br=1018&bt=509&cs=0&ds=3&ft=XE5bCqT0majPD12WNooJ3wUOx5EcMeF~O5&mime_type=video_mp4&qs=0&rc=Z2VmZzpkZ2QzaWk2OTQ0ZkBpamZyanc5cnZ0dzMzODczNEA1YWAxNF41Nl8xXmIzLi9hYSNiNG1jMmRrNDFgLS1kMWBzcw%3D%3D&vvpl=1&l=2024120614561283F7906C54C46711091A&btag=e00088000",
                                            "size": 2006220,
                                            "wm_size": 2156180,
                                            "music": "https:\/\/sf16-ies-music-sg.tiktokcdn.com\/obj\/tiktok-obj\/7441981912560306961.mp3",
                                            "music_info": {
                                                "id": "7441981929378908945",
                                                "title": "Im your Christmas present baby demo",
                                                "play": "https:\/\/sf16-ies-music-sg.tiktokcdn.com\/obj\/tiktok-obj\/7441981912560306961.mp3",
                                                "cover": "https:\/\/p16-sign-sg.tiktokcdn.com\/tos-alisg-avt-0068\/ecabb66a513171d928aed23eb10cb3f8~tplv-tiktokx-cropcenter:1080:1080.jpeg?dr=14579&nonce=48248&refresh_token=7decca88f093715dc82680f8f84ad61a&x-expires=1733580000&x-signature=v9YDs02X3PeMw641nW75604RWo0%3D&idc=maliva&ps=13740610&shcp=d05b14bd&shp=45126217&t=4d5b0474",
                                                "author": "T\u1ee7 demo c\u1ee7a \u0110\u1ee9c",
                                                "original": true,
                                                "duration": 33,
                                                "album": ""
                                            },
                                            "play_count": 4554719,
                                            "digg_count": 371819,
                                            "comment_count": 1085,
                                            "share_count": 12403,
                                            "download_count": 2947,
                                            "collect_count": 61788,
                                            "create_time": 1732879352,
                                            "anchors": null,
                                            "anchors_extras": "",
                                            "is_ad": false,
                                            "commerce_info": {
                                                "adv_promotable": false,
                                                "auction_ad_invited": false,
                                                "branded_content_type": 0,
                                                "with_comment_filter_words": false
                                            },
                                            "commercial_video_info": "",
                                            "item_comment_settings": 0,
                                            "mentioned_users": "",
                                            "author": {
                                                "id": "6816583276594103298",
                                                "unique_id": "promisedaxix",
                                                "nickname": "\ud835\udc77\ud835\udc93\ud835\udc90\ud835\udc8e\ud835\udc8a\ud835\udc94\ud835\udc86?",
                                                "avatar": "https:\/\/p16-sign-sg.tiktokcdn.com\/tos-alisg-avt-0068\/65bd66acb6bfdbe47863d77bf6b96448~tplv-tiktokx-cropcenter:300:300.jpeg?dr=14577&nonce=96173&refresh_token=591a7a24aa4f107d61b346e1faee7231&x-expires=1733580000&x-signature=3PmySHaSZfb9TnaRSlL%2B4eM61lY%3D&idc=maliva&ps=13740610&shcp=d05b14bd&shp=45126217&t=4d5b0474"
                                            }
                                        }
                                    }</span> 
                            </code>
                         </pre>
                    </div>
              </div>
        </div>
        <div class="py-5">
            <h1 class="anchor fw-bold mb-5" id="basic" data-kt-scroll-offset="50">
                <a href=""></a>               
                API YouTube</h1>
            <div class="highlight">
                <div class="highlight-code">
                    <pre class="language-php">
                        <code>
                    GET {{ route('api.youtube') }}?url=https://www.youtube.com/watch?v=zmeoTghPCEA
                        </code>
                    </pre>
                    <pre class="language-html" tabindex="0">
                        <code class="language-php">                               
                                <span class="token tag">
                                    <span class="token string double-quoted-string"></span>{
                                        "api": {
                                          "service": "YouTube",
                                          "status": "OK",
                                          "message": "Processing started.",
                                          "id": "zmeoTghPCEA",
                                          "title": "MIXTAPE #1 - MỘT TRIỆU LIKE, LỐI NHỎ, THĂM CỐ TRI | ĐEN VÂU (VIETZ ft. WIRARWR REMIX)",
                                          "description": "List nhạc trong video:\n00:00 Lối Nhỏ x 424 - Đen Vâu (VietZ Remix)\n03:11 Một Triệu Like x Le Tour De Trance - Đen Vâu (VietZ Remix)\n08:25 Thăm Cố Tri - VietZ x WirArwr Remix\n12:19 Là Một Thằng Con Trai - J97 - Hương Ly Cover (VietZ Remix)\n15:32 Đừng Về Trễ - Sơn Tùng M-TP (VietZ Remix)\n20:30 Cho Em Gần Anh Thêm Chút Nữa - Hương Tràm (VietZ Remix)\n\nTheo Dõi Tôi: \nSpotify: https://open.spotify.com/artist/4fzrXBdIwhgk8dqWiBzhpx?si=DO8-Wc2IT82XrP6iKnlofA\nApple Music: https://music.apple.com/us/artist/vietz/1718886903\nDeezer: https://www.deezer.com/en/artist/33867021\nYouTube:  @vietzofficial24 \nTikTok: https://www.tiktok.com/@vietzremix03\n\n✉ Contact: viethanso453@gmail.com\nĐối với mọi vấn đề bản quyền âm thanh, hình ảnh và công việc xin liên hệ với tôi theo email trên.\n(For all audio, visual and work copyright issues, please contact me via the email above).\n#VietZ#Songs#nhac#remix#vinahouse#nonstop",
                                          "previewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=18&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFTSS26ggRGL9rwwa5uin6rxVDXHN_hzRlkcpjMNSsvyWPZMnYi1MU3jdKvMWKPYq-NHZg&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=73139471&ratebypass=yes&dur=1620.985&lmt=1732753053850081&mt=1733496565&fvip=1&fexp=51326932%2C51335594%2C51347747&txp=5438434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cratebypass%2Cdur%2Clmt&sig=AJfQdSswRAIgLFibeeWlEYMTSvw2gYYlbwTEbyUf8uncTCM3g-WeNdYCIA5QMTcPYKbGD8OqwWLMTikXeWR4MURmpMlUFrU1Zk5U&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                          "imagePreviewUrl": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                          "permanentLink": "https://www.youtube.com/watch?v=zmeoTghPCEA",
                                          "userInfo": {
                                            "name": "VietZ",
                                            "userCategory": false,
                                            "userBio": false,
                                            "username": "@vietzofficial24",
                                            "userId": "UCX0uwhDCCBEub0CLscNObSA",
                                            "userAvatar": "https://api.adcdn.xyz/v3/d/image/UCX0uwhDCCBEub0CLscNObSA/UCX0uwhDCCBEub0CLscNObSA/IfQH-cYvAqxieKJD1COsDhcmPEdEwqRhz4p2Opg1heko-V1-cn5kZaW-cM7pGdrfEy0jEVdv=s160-c-k-c0x00ffffff-no-rj?token=17334970903901a546a031795ddd25aeffbc1d32e5",
                                            "userPhone": false,
                                            "userEmail": false,
                                            "internalUrl": "https://www.youtube.com/@vietzofficial24",
                                            "externalUrl": "https://youtube.com/BoylerVN",
                                            "accountCountry": "Vietnam",
                                            "dateJoined": "Jun 11, 2017",
                                            "isVerified": false,
                                            "dateVerified": false
                                          },
                                          "mediaStats": {
                                            "mediaCount": "31",
                                            "followersCount": "14.5K",
                                            "followingCount": false,
                                            "likesCount": false,
                                            "commentsCount": "47",
                                            "favouritesCount": false,
                                            "sharesCount": false,
                                            "viewsCount": "102K",
                                            "downloadsCount": false
                                          },
                                          "mediaItems": [
                                            {
                                              "type": "Video",
                                              "name": "Media #001",
                                              "mediaId": "1732752911676088",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732752911676088/1080p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=137&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=80671616&dur=1620.933&lmt=1732752911676088&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRgIhAM-k3Vxmq7BeRhmbOhs1eQAqYje7mssRRK6BpqvIiajyAiEAw_XCEngNJLCv9ITjYnlygYiZYW4k6due91G64DSwK-k%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "1906x1080",
                                              "mediaQuality": "FHD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "102.21 MB",
                                              "mediaTask": "merge"
                                            },
                                            {
                                              "type": "Video",
                                              "name": "Media #002",
                                              "mediaId": "1732753084791022",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732753084791022/720p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=136&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=25581004&dur=1620.933&lmt=1732753084791022&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRAIgAJxI6rv5iZec_2nQmanZBagyvpb7SpriXOEfEdUtAtkCIHrvvnhIqXR0dY5WGea7HjS7en5ymyB0Aia0THsW0PyK&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "1270x720",
                                              "mediaQuality": "HD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "49.54 MB",
                                              "mediaTask": "download"
                                            },
                                            {
                                              "type": "Video",
                                              "name": "Media #003",
                                              "mediaId": "1732753081847160",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732753081847160/480p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=135&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=18093820&dur=1620.933&lmt=1732753081847160&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRgIhAKynuefkxjkalCjdpG8Hhp_FmuTF9Efcy6NRavWF1m1gAiEA6CFIzDHJpt2_of9wsW6sJ22jM_LCu8ixAZwIkBUz2aw%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "848x480",
                                              "mediaQuality": "SD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "42.38 MB",
                                              "mediaTask": "merge"
                                            },
                                            {
                                              "type": "Video",
                                              "name": "Media #004",
                                              "mediaId": "1732753083442990",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732753083442990/360p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=134&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=13592955&dur=1620.933&lmt=1732753083442990&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIhAM3swxfx6eTLdgs9pdJWoF8YHJ493Ny9Aliy9Fan91AFAiAi1qWkoLsBmNzVLMGqzRDdeOz-YKk0OX5iv5GJ0o62jA%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "636x360",
                                              "mediaQuality": "SD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "38.08 MB",
                                              "mediaTask": "download"
                                            },
                                            {
                                              "type": "Video",
                                              "name": "Media #005",
                                              "mediaId": "1732753209676880",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732753209676880/240p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=133&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=8349002&dur=1620.933&lmt=1732753209676880&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIhAKdYXgqHIA64jovXuM-vxBM8iSrNvjZIOzRvR25K9fyVAiB4b0V1GyOBB7ZDo42E-BzlQiS3SQeyN_gtOFBqRzlNbw%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "424x240",
                                              "mediaQuality": "SD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "33.06 MB",
                                              "mediaTask": "merge"
                                            },
                                            {
                                              "type": "Video",
                                              "name": "Media #006",
                                              "mediaId": "1732753084764504",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/videoProcess/zmeoTghPCEA/1732753084764504/144p",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=160&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=video%2Fmp4&rqh=1&gir=yes&clen=4425533&dur=1620.933&lmt=1732753084764504&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRgIhAKXBA8LfWhODsesw1uDqiloa916suEdu3EdEFaorgnJ7AiEA_fGgZ-Ag9Dzf9TrPwYosqcqhuKQFBny-F-GC0xUMghM%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": "254x144",
                                              "mediaQuality": "SD",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "MP4",
                                              "mediaFileSize": "29.31 MB",
                                              "mediaTask": "merge"
                                            },
                                            {
                                              "type": "Audio",
                                              "name": "Media #007",
                                              "mediaId": "1732753084764504",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/audioProcess/zmeoTghPCEA/1732753084764504/48k",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=139&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=audio%2Fmp4&rqh=1&gir=yes&clen=9885767&dur=1621.077&lmt=1732752526542701&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIhAIjtHoAYnCkgspMhiP2fnwqJyYiShgtiZP00Gw_JRqsUAiAbYH7g7aRxHdwdY_dy0ecP2Kxp8dI0qG1LKV0RifIiIg%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": false,
                                              "mediaQuality": "48K",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "M4A",
                                              "mediaFileSize": "9.42 MB",
                                              "mediaTask": "download"
                                            },
                                            {
                                              "type": "Audio",
                                              "name": "Media #008",
                                              "mediaId": "1732753084764504",
                                              "mediaUrl": "https://api.adcdn.xyz/v3/audioProcess/zmeoTghPCEA/1732753084764504/128k",
                                              "mediaPreviewUrl": "https://rr3---sn-4g5lznek.googlevideo.com/videoplayback?expire=1733518689&ei=ARFTZ7zMG8OH6dsP08Wu4Qw&ip=2a01%3A4f8%3A162%3A4011%3A%3A2&id=o-ADRYnfCibymcUi5PDLrrFoU70ByqQ_JDi99nrTcPyVDr&itag=140&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1733497089%2C&mh=Un&mm=31%2C26&mn=sn-4g5lznek%2Csn-f5f7lnl6&ms=au%2Conr&mv=m&mvi=3&pl=44&rms=au%2Cau&ctier=A&pfa=5&initcwndbps=716250&hightc=yes&siu=1&bui=AQn3pFT1U3LMjkdI0c8b8F8KXfxXkA4q41WgmBB2lBesoY88BPgyZCSWrp87jzzBt7fajLQw7w&vprv=1&mime=audio%2Fmp4&rqh=1&gir=yes&clen=26234663&dur=1620.984&lmt=1732752522472024&mt=1733496565&fvip=1&keepalive=yes&fexp=51326932%2C51335594%2C51347747&txp=5432434&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cctier%2Cpfa%2Chightc%2Csiu%2Cbui%2Cvprv%2Cmime%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIgUtDnX01wYkgYuescBoqyOF_6Eu1Fx-oS6TWP_qSPUwgCIQCbWeq2eD1b5DwKM0TDfx5P-QiF3BGWKsIco0upRyaVjA%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=AGluJ3MwRQIhAJ7usmcXWoI8mxLzqO-wiNJFAx-NbGM5TMVvd7tukuBCAiBZRXbKkcYsoLJLZ4saQ4kzjTND-DFFP1ggcJHEqXqedQ%3D%3D",
                                              "mediaThumbnail": "https://i.ytimg.com/vi/zmeoTghPCEA/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AH0CYAC0AWKAgwIABABGFwgXChcMA8=&rs=AOn4CLDZlesJDdLwbsltnFlXa-mLp1CoqQ",
                                              "mediaRes": false,
                                              "mediaQuality": "128K",
                                              "mediaDuration": "00:27:00",
                                              "mediaExtension": "M4A",
                                              "mediaFileSize": "25.01 MB",
                                              "mediaTask": "download"
                                            }
                                          ]
                                        }</span> 
                            </code>
                         </pre>
                    </div>
              </div>
        </div>
    </div>        
</div>
@endsection
