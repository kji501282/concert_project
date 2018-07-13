<?php 
session_start();
$userid = $_SESSION['userid'];
$real_name = $_GET['real_name'];
$file_type = $_GET['file_type'];
$show_name = $_GET['show_name'];
?>
<?php 
if(!$userid){
    echo("
        <script>
        window.alert('로그인 후 이용하세요.')
        history.go(-1)
        </script>
    ");
    exit;
}
$file_path = "./data/".$real_name;

if(file_exists($file_path)){  // file_exists :다운로드 할 파일이 존재하는지 확인.
   
    $fp=fopen($file_path, "rb"); // 첫번째는 파일명과 경로 , 두번째는 읽기모드(r:읽기모드 w:쓰기모드 b:이진(binary모드) 파일을 열어 파일이 있는 위치를 가르키는 파일 포인터를 반환.
    
    if($file_type){ // header : 클라이언트측 웹 브라우저에 보낸다. 반환값X(Void임)
        header("Content-type: application/x-msdownload"); //   파일의 형식 / 모든 웹 브라우저에서 사용 가능 
        header("Content-Length: ".filesize($file_path)); // 파일 크기
        header("Content-Disposition: attachment; filename=$show_name"); // filename이 무엇인지 알려준다.
        header("Content-Transfer-Encoding: binary"); // 이진 방식으로 인코딩
        header("Content-Description: File Transfer"); // 파일 전송
        header("Expires: 0"); // 대기시간이 끝나면 파일 전송을 취소
    } else{
        if(eregi("(MSIE 5.0 | MSIE 5.1 | MSIE 5.5 | MSIE 6.0)",$HTTP_USER_AGENT)){ // 익스플로러 6.0버전 이하에서 사용
            header("Content-type: application/octet-stream");
            header("Content-Length: ".filesize($file_path));
            header("Content-Disposition: attachment; filename=$show_name");
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
        } else{
            header("Content-type: file/unknown"); // 그 이외의 웹 브라우저에서 
            header("Content-Length: ".filesize($file_path));
            header("Content-Disposition: attachment; filename=$show_name");
            header("Content-Description: PHP3 Generated Data");
            header("Expires: 0");
        }
    }
    if(!fpassthru($fp)){ // 포인터가 위치해 있는 곳의 파일을 읽어서 저장(클라이언트 컴퓨터로 파일 전송)
        fclose($fp);
    }
}
?>
