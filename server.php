<?php

class Generate
{
    public string $public_key="
    MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCp2g6o0EFsjuNO88Nfd9pNW0NOB7a/lYcrvHZIlMPWKM08B454qD+MZMZqqRfiAB3rPMymMRnaRJzWBVJEMPaMMngp7SymEIsXNjXeE6oBZgAacVWCUXf5pjqZmAsynLIMSSI1N5l8mwL9HO87JeeHk/Z9bm6PGvG9O9zmkIL96rcnjEld53kIvUjzU9rLiT1TX4xLd66airetIXaa3nQCdoh5Lr5h2CjL7NgK9b7EQtt1aS2/izXpdSmx9TJX0hUj4Uw/5PKMxvsI6Qf0+6xawan3wfKnA/hBSX7hI3FnxcT9Vs0ML0I719LOgyYpFEQtWJgqa2hpN+AqURzdvQg3AgMBAAECggEBAKZiVG/sKdq1Eli6E44Gs1OJ7iGXDt8YFCS05k3tZPX6XCnM4TSy5CWcZn3/jMS4Bpb0pSi7+q5E/jntVow0RqBJpEq16kH2/LnNQfF849Gg4MMGeJRDSDrHKqphNb7rnsLINXlaMMHOe5wFZxhS5j56pEB1GFqZM2uDI768m4UtefcBkGp9E0+FxNNMqTyJ7P6Fs6v8B4SBO83nLHxWcVNlg7I0FerAJ85BwYucz4odJOJWGM+kRnecbPxmmt7PMljgxnzFUFuf7pOhnZyUQRDL+vxVhmGiH+TCbNstyrcomPIJCJVgRDopgZT/1+l76MpprjwGEEUx3w5RTGFkxjkCgYEA3HqFikCQUO6sQd/V9pbpfLjChy6ysH1ZIBTESdR69X0VVhHad0J5jQzMKXIyNtuG3p5xjXiccr1z6BEn1alpNW0tCtIxrz9FFn3dMicMO90Fdnde6X7DReMDMdf22Q8IsJEp5ywWYqpgDmbeKrCLlHkXJGaBOyvCA7nRT3JsXRUCgYEAxTd4QoilFEPeQ5uPCTWvIF1KDJcjYZIWVe9OQ4KdnGF86AcsTj21/5k1E01YSam4Mw6lb+J07L9AYbaLUoHcI4vlkJaT86WNbpuL0PZ0MCWjDFqeRdDk8qs1yjAywaFmP9VCvllAx2CzVsigDdIKU35Zcm9CwpYwHOsPi3AGGxsCgYBmLHVkS2VVzDWR1YxPWUJc5TZo9TAj8AL0hgss98X/q/bOSznF2M2BmzOl5WD14SgQVLbky8ccuUVUf1bJglfaRX0BLcWOpDB9KtjuHABkYZnde5ZFeNQ/t+NMHvwrPPdW8/7KPbkmAjS/l9ZPTD9zD+a0nLg41p9zoJIqUil7vQKBgQCojDGhWzsKSL6KNUZXbqQPGuuQOxMn7jxckTroA5dD8SVY/9hjveXvXja4GmAcBIrCSAAn0Phw5TrWx7Xme8lyL7uwiKBFmPV41EL4Aclm5KOmiUO/Ezq4Eo7UD8ExLwk+ALscBxePzhs3ThtL9HiSxucXH/OEbesMq/ALEWCGhQKBgHWtwr+M18KkWdcXqh/Jmolh4ydcZ5SLvDZWclWD3X21Sd7Bt/uRBaUuJuy1wHeMchDg6w9hyB0GqXHUzk3C0KQ7N99Fci5MV735PJ9H59WZekV1vPueK8LHpOSQ7LfP9eckXyKZV6qvu/pNlipTYBHFca8hm0IHmZWbeilKjayl
    ";  // 用于签名Token的密钥

    public function generateToken(): string
    {
    $payload = array(
        "iss" => "http://localhost",
        "aud" => "http://localhost",
        "iat" => time(),
        "nbf" => time(),
        "exp" => time() + 3600, // Token的有效期（例如：1小时）
        "data" => array(
            "user_id" => "admin", // 用户的唯一标识或其他自定义数据
        )
    );

    // 生成Token
    $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payloadEncoded = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payloadEncoded", $this->public_key, true);
    $token = "$header.$payloadEncoded." . base64_encode($signature);

    echo $token; // 将Token发送给客户端，通常是通过HTTP响应头或响应体
    return $token;
    }
}
$generate = new Generate();// 假设这里有一个生成token的函数

$token = $generate->generateToken();

// 设置HTTP Only Cookie
setcookie('SHISHEN', $token, time() + (3600*24), '/', 'localhost', true, true);