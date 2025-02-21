<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        /* 全体のフォントと背景 */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: auto;
        }
        
        /* 段落 (p) */
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        /* 定義リスト (dl) */
        dl {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
        dt {
            font-weight: bold;
            color: #2b80ff;
            margin-top: 10px;
        }
        dd {
            margin-left: 10px;
            font-size: 14px;
            color: #666;
        }

        /* 表 (table) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #2b80ff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* ボタン */
        .button {
            background-color: #ec003f;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="email-container">
    @yield('content')
</div>
</body>
</html>