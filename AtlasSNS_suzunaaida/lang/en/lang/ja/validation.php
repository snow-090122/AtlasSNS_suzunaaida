<?php

return [
  'required' => ':attribute は必須項目です。',
  'email' => ':attribute は正しいメールアドレス形式で入力してください。',
  'min' => [
    'string' => ':attribute は最低 :min 文字以上で入力してください。',
  ],
  'max' => [
    'string' => ':attribute は最大 :max 文字までです。',
  ],
  'confirmed' => ':attribute が確認用と一致しません。',
  'exists' => ':attribute は登録されていません。',
  'throttle' => 'ログイン試行が多すぎます。:seconds秒後に再試行してください。',

  'attributes' => [
    'name' => '名前',
    'username' => 'ユーザー名',
    'email' => 'メールアドレス',
    'password' => 'パスワード',
    'password_confirmation' => 'パスワード確認',
    'bio' => '自己紹介',
    'icon_image' => 'アイコン画像',
  ],
];
