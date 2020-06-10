# laravel-ddd-starter
## Descriptions
便利なやつがいろいろ入ってる

## How To Set Up This App

1. Copy .env.example to .env
2. Run `composer install`
3. Run `npm install`
4. Run `php artisan key:generate`
5. Run `php artisan migrate`


## Start server

For local,
```
php artisan serve
```

## Front-end Dev

- For development
```
npm run dev
```
```
npm run watch
```

## ddd
https://little-hands.hatenablog.com/entry/2018/12/10/ddd-architecture

```
- packages
  - Domain
    - Application
     => usecaseの実装クラス
    - Domain
     => domainやvalue object, domain service, repositoryのinterfaceの実装

  - Infrastructure
  => repository, QueryServiceの実装クラスや外部api(ExternalApi)、通知の実装

  - InMemoryInfrastructure
  => Infrastructure層の実装をtest用にmock化したもの

  - MockInteractor
   => usecaseの実装クラスをtest用にmock化したもの

  - UseCase
   => usecaseのinterfaceやQueryServiceのinterface, input bounday, output boundayを実装
```

```
memo
- 通知系は本来ユースケース層にNotificationAdapterといった名前のインターフェイスを定義し、実装クラスはインフラ層に配置する

- 外部 API から取得した値の詰め替え方法
外部APIに渡す値、外部APIから取得する値が、ドメインモデルとして意味を持つのであれば、ドメイン層のものとして定義してリポジトリで設計する
リポジトリのインターフェイスはドメイン層であり、ドメインの知識としては「どういう条件を指定したらどういうオブジェクトが取得できるか」と いう定義 (What) にだけ関心があり、その How は隠蔽したいのです。API の呼び出し方 や、取得結果を戻り値のオブジェクトに変換する方法はあくまでインフラ層の関心ごとに なるので、インフラ層のクラスの中で完全に隠蔽するのが望ましい

- ドメインサービスは、「モデルをオブジェクトとして表現すると無理があるもの」の表 現に使います。例えば、集合に対する操作などです。
よく使われるのはユーザーのメールアドレスを更新する際の重複チェックです。「指定されたメールアドレスはすでに使われているか?」と尋ねたいとき、その知識を 1 つの ユーザーオブジェクト自身が答えられる、とするのは無理があります。自分自身のメール アドレスを知っていても、他のオブジェクトの状況については情報を持っていないからです。こういう場合に、ドメインサービスを使用します。
ただし、極力エンティティと値オブジェクトで実装するようにして、どうしても避けら れない時にのみドメインサービスを使うようにしてください。ドメインサービスは手続き 的になるので、従来の「ビジネスロジック層」の感覚で書いてしまいがちです。そうする と、結局従来のようなファットなクラスが異なるレイヤーに現れただけ、という結果に なってしまいます。

```

Create usecase files including usecase, usecase`s interface, inputdata, outputdata
```
php artisan make:usecase {domain : name of domain name} {usecaseName : The name of usecase}
```

create repository file
```
php artisan make:repository {repository : name of repository name}
```

