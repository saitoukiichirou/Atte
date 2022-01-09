# Atte

- シンプルな打刻勤怠管理アプリケーション
- [Atteトップ画面へ](http://pacific-wave-41500.herokuapp.com/)

# Features
- シンプルで使いやすい打刻UI
- 日毎・月毎(ユーザー別)表示が可能な勤怠履歴表示

# Requirement

* MySQL v5.7.32
* Laravel v8.78.1


# Usage

- ユーザー登録

  初回の方は /register にてユーザー登録をしてください。

  登録に必要な情報は「メールアドレス」「登録者の名前」「8文字以上の任意のパスワード」です。

  登録ボタンをクリックすると登録時のメールアドレス宛に確認メールが届きますので、メール本文内にある「登録を完了する」ボタンをクリックしアカウントが本登録されます。


* サンプルアカウント

  email : laravel.test.3110@gmail.com

  password : 12345678



- ログイン

  /login にて登録時のメールアドレスと自身で設定した任意のパスワードでログインしてください。


- ホーム画面

  出退勤、休憩の記録をする画面。「勤務開始」「勤務終了」「休憩開始」「休憩終了」の4つのボタンがあります。

  「休憩開始」「休憩終了」ボタンは「勤務開始」ボタンを押下後に表示されます。「勤務終了」ボタン押下後は再び非表示になります。

  休憩は1日に何度も取得可能です。但し、「休憩終了」ボタン押下後でないと「勤務終了」ボタンは押せないようになっています。

  「勤務開始」「勤務終了」は1日に1度しか押せません。勤務開始状態で日付が変わった時は、勤務開始日の23時59分59秒が退勤時刻に、翌00時00分00秒が勤務開始時刻として「勤務終了」ボタンを押下時に記録されます。


- 日付一覧画面

  アクセスした当日の勤怠データがあるユーザ全員の情報が表示されます。

  年月日表示の左右にある「＜」「＞」ボタンで日戻り・送りができます。
  

- ユーザー一覧画面

  登録ユーザー(仮登録状態含む)の名前・登録日時・登録メールアドレスが一覧で確認できます。

  名前をクリックすることでユーザー個別の月毎勤怠情報画面(次項参照)へジャンプできます。

  メールアドレスをクリックすることで既定のメーラーよりメールを送ることができます。


- 月毎勤怠情報画面

  ユーザー一覧画面(前項)のユーザーの名前をクリックすると、そのユーザーの当月の勤怠情報が一覧で表示されます。

  年月表示の左右にある「＜」「＞」ボタンで月戻り・送りができます。


- パスワード再設定画面

  /forgot-password にてパスワード失念時の再設定ができます。

  登録時のメールアドレスを入力しボタンを押すとパスワードリセットメールが届きます。

  パスワードリセットボタンをクリックすると入力したメールアドレス宛に再設定用のメールが届きますので、メール本文内にある「パスワード再設定」ボタンをクリックし再設定画面へジャンプします。

  入力フォームに「登録時のメールアドレス」と「再設定用のパスワード」を入力しボタンを押すとパスワードの更新が完了します。

# Note

動作確認ブラウザーは以下の通りです
* PC：Chrome/Firefox/Safari 最新バージョン
* SP：iOS/AndroidOS　chrome/Safari 最新バージョン

# Author

* 作成者 斉藤騎一郎
* 所属　coachtech受講生
* E-mail　[kiichi0213@gmail.com](mailto:kiichi0213@gmail.com)

# License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
