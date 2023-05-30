# iced-americano
PHP로 작성된 웹 서비스용 마이크로 프레임워크

# 목적
라우팅, 세션, 데이터베이스 등의 기능을 제공하는 웹 프레임워크를 PHP로 작성한다.

# 목표
- 라우팅: HTTP 메서드, 경로, 핸들러, 미들웨어를 등록하여 실행할 수 있다.
- 데이터베이스: 기본적으로 MySQL을 사용한다. 연결 후 DML 로직을 제공한다.
- 세션: 데이터베이스를 이용하여 세션 데이터를 관리할 수 있다.
- 테마: 템플릿 엔진과 유사하게 HTML 템플릿을 선택하고 변수를 건네어 페이지를 유저에게 보여줄 수 있다.
- 모듈화: 유저가 제공한 모듈을 기반으로 웹 서비스가 동작한다.
# 구현
## 라우팅
- 디렉토리: Routing
- 파일: Route.php, RequestContext.php, Middleware.php
- 라우팅은 HTTP 요청에 대한 응답을 정의한다. 필요한 정보에 HTTP 메서드, 경로 그리고 응답 동작을 정의한 핸들러가 있다.
- 경로에는 '/post'와 같은 정적인 경로와 '/post/{id}'같은 동적인 경로가 있으므로 이를 위한 처리가 필요하다.
- `Middleware`는 여러 라우트에서 공통으로 쓸 수 있는 핸들러를 정의한 것이다. 응답을 위한 메인 핸들러가 있고, 그 전에 미들웨어들이 호출된다.
- `RequestContext`는 라우팅을 하기 위한 재료를 관리하는 단위이다.
  - `match`메서드는 비교할 URL을 인자로 받아, 현재 `RequestContext`가 담당하는 요청인지 확인한다. 그리고 매칭이 확인되면, 동적 경로에 담긴 데이터를 반환한다.
  - `runMiddleware`메서드는 등록된 미들웨어를 모두 실행한다.
- `Route`는 라우팅을 담당하는 주체이다. `RequestContext`를 이용하여 라우트를 등록하고, 실행할 수 있다.
  - `run`메서드는 HTTP 요청 정보와 등록된 라우트를 비교하여 실행한다.
  - get, post, delete 등의 HTTP 메서드와 경로를 확인하고, 동적 경로에 해당하는 데이터를 추출하여 핸들러와 함께 호출한다.
## HTTP 요청
- 디렉토리: Http
- 파일: Request.php
- 서버에 들어온 HTTP 요청을 분석하여 메서드, 경로 추출 기능을 제공한다.
## 데이터베이스
- 디렉토리: Database
- 파일: Adaptor.php
- 내부에서 PDO를 사용하여 데이터베이스에 접근하다. prepared statement를 사용하여 sql injection을 대비했다.
- `exec`메서드로 CRUD를 처리할 수 있다.
- `getAll`메서드로 테이블에서 데이터를 가져오면서 클래스를 지정하여 해당 클래스의 인스턴스로 데이터를 받아올 수 있도록 하였다.
## 세션
- 디렉토리: Session
- 파일: DatabaseSessionHandler.php
- PHP에서 세션을 위해 지원하는 SessionHandlerInterface를 상속받아 클래스를 구성했다.
- 내부에서 `Adaptor`클래스를 사용한다.
- 세션에 저장한 데이터는 그대로 데이터베이스에 저장되어 관리된다.
## 테마
- 디렉토리: Support
- 파일: Theme.php
- 템플릿 엔진처럼 미리 작성된 레이아웃을 불러와 사용할 수 있도록 구조화 했다.
- `view`메서드에서는 Variable variables($$를 이용하여 문자열을 변수 이름으로 치환하는 기법)을 사용하여 인자로 넘긴 연관 배열의 키를 레이아웃의 변수 이름으로 사용할 수 있다.
- `setLayout`메서드는 한 번 호출되어 전체 레이아웃(헤더, 네비게이션, 메인, 푸터)을 책임진다. `view`메서드에서 바뀌는 것은 메인이 될 것이다.
## ServiceProvider
- 디렉토리: Support
- 파일: ServiceProvider.php
- ServiceProvider는 유저가 서비스(서버가 실행되는 동안 진행할 로직)를 등록할 수 있도록 제공하는 껍데기이다.
- 최초에 abstract class였지만 내부 동작이 없기에 interface로 변경하였다.
## Application
- 디렉토리: 루트(src디렉토리)
- 파일: Application.php
- ServiceProidver로 받은 서비스들을 등록하고, 실행한다.
- 유저는 제공하려는 서비스들을 ServiceProidver로 만들어 Application에 제공하여 자기 자신만의 웹 서비스를 만들 수 있다.
# 참고
이 코드는 [PHP 7+ 프로그래밍: 객체지향](https://www.inflearn.com/course/php7-oop#reviews)강의를 바탕으로 작성함.
