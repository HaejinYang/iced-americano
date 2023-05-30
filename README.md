# iced-americano
micro framework written in PHP

# 목적
라우팅, 세션, 데이터베이스 등의 기능을 제공하는 웹 프레임워크를 PHP로 작성한다.

# 목표
- 라우팅: HTTP 메소드, 경로, 핸들러, 미들웨어를 등록하여 실행할 수 있다.
- 데이터베이스: 기본적으로 MySQL을 사용한다. 연결 후 DML 로직을 제공한다.
- 세션: MySQL에 세션 테이블을 만들고, 세션 데이터를 관리할 수 있다.
- 테마: 템플릿 엔진과 유사하게 HTML 템플릿을 선택하고 변수를 건네어 페이지를 유저에게 보여줄 수 있다.

# 구현
## 라우팅

## 데이터베이스
- 디렉토리: Database
- 파일: Adaptor.php
- 내부에서 PDO를 사용하여 데이터베이스에 접근하다. prepared statement를 사용하여 sql injection을 대비했다.
- `exec` 메서드로 CRUD를 모두 처리할 수 있다.
- `getAll` 메서드로 테이블에서 데이터를 가져오면서 클래스를 지정하여 해당 클래스의 인스턴스로 데이터를 받아올 수 있도록 하였다.
## 세션
- 디렉토리: Session
- 파일: DatabaseSessionHandler.php
- PHP에서 세션을 위해 지원하는 SessionHandlerInterface를 상속받아 클래스를 구성했다.
- 내부에서 `데이터베이스`에서 구현한 `Adaptor`클래스를 사용한다.
- 세션에 저장한 데이터는 그대로 데이터베이스에 저장되어 관리된다.
## 테마
- 디렉토리: Support
- 파일: Theme.php
- 템플릿 엔진처럼 미리 작성된 레이아웃을 불러와 사용할 수 있다.
- `view` 메서드에서는 Variable variables($$를 이용하여 문자열을 변수 이름으로 치환하는 기법)을 사용하여 인자로 넘긴 연관 배열의 키를 레이아웃의 변수 이름으로 사용할 수 있다.
- `setLayout` 메서드는 한 번 호출되어 전체 레이아웃(헤더, 네비게이션, 메인, 푸터)을 책임진다. `view`메서드에서 바뀌는 것은 메인이 될 것이다.
## ServiceProvider
- 디렉토리: Support
- 파일: ServiceProvider.php

# 참고
이 코드는 [PHP 7+ 프로그래밍: 객체지향](https://www.inflearn.com/course/php7-oop#reviews)강의를 바탕으로 작성함.
