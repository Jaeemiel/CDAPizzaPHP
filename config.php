<?php

return [
    "app" => [
        "name" => "CDAPizza",
    ],
    "database" => [
        "pizzeria" => [
            "host"     => "db",       // même service Docker
            "name"     => "CDAPizza",
            "username" => "lambdas",
            "password" => "lambdas",
        ],
        "personnel" => [
            "host"     => "db",       // même service Docker
            "name"     => "CDApersonnel",
            "username" => "lambdas",
            "password" => "lambdas",
        ],
    ],
];