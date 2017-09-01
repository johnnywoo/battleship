<?php

class BattleshipTest extends \PHPUnit\Framework\TestCase {
    public function testEmptyBoard() {
        //   1234567890
        // a           |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('')['is_valid']);
    }

    public function testOneShip() {
        //   1234567890
        // a *         |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1')['is_valid']);
    }

    public function testTwoShips() {
        //   1234567890
        // a * *       |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1 a3')['is_valid']);
    }

    public function testThreeShips() {
        //   1234567890
        // a * * *     |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1 a3 a5')['is_valid']);
    }

    public function testFourShips() {
        //   1234567890
        // a * * * *   |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(true, $this->getApiResponse('a1 a3 a5 a7')['is_valid']);
    }

    public function testFourShipsAlternative() {
        //   1234567890
        // a * * * *   |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(true, $this->getApiResponse('a5a3a1a7')['is_valid']);
    }

    public function testFiveShips() {
        //   1234567890
        // a * * * * * |
        // b           |
        // c           |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1 a3 a5 a7 a9')['is_valid']);
    }

    public function testLargeShipsBad() {
        //   1234567890
        // a ##        |
        // b           |
        // c   ##      |
        // d           |
        // e           |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1a2 c3c4')['is_valid']);
    }

    public function testOneLargeShipGoodHorizontal() {
        //   1234567890
        // a ##        |
        // b       *   |
        // c    *      |
        // d           |
        // e     *     |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(true, $this->getApiResponse('a1a2 b7 c4 e5')['is_valid']);
    }

    public function testOneLargeShipGoodVertical() {
        //   1234567890
        // a #         |
        // b # *       |
        // c           |
        // d     *     |
        // e           |
        // f  *        |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(true, $this->getApiResponse('a1b1 b3 f2 d5')['is_valid']);
    }

    public function testTwoLargeShips() {
        //   1234567890
        // a ##        |
        // b     *     |
        // c   *       |
        // d     #     |
        // e     #     |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(true, $this->getApiResponse('a1a2 b5 c3 d5e5')['is_valid']);
    }

    public function testThreeLargeShips() {
        //   1234567890
        // a           |
        // b    ##     |
        // c #         |
        // d #         |
        // e       #   |
        // f       #   |
        // g           |
        // h           |
        // i           |
        // j          *|
        $this->assertSame(true, $this->getApiResponse('b5b4 d1c1 e7f7 j10')['is_valid']);
    }

    public function testFourLargeShips() {
        //   1234567890
        // a ##        |
        // b           |
        // c   ##      |
        // d           |
        // e       #   |
        // f       #   |
        // g           |
        // h           |
        // i         ##|
        // j           |
        $this->assertSame(true, $this->getApiResponse('a1a2 c3c4 e7f7 i9i10')['is_valid']);
    }

    public function testFiveLargeShips() {
        //   1234567890
        // a        ## |
        // b   ##      |
        // c           |
        // d   ##      |
        // e       #   |
        // f       #   |
        // g           |
        // h           |
        // i         ##|
        // j           |
        $this->assertSame(false, $this->getApiResponse('a8a9 b3b4 d3d4 e7f7 i9i10')['is_valid']);
    }

    public function testSpacedShips() {
        //   1234567890
        // a # #       |
        // b     # #   |
        // c           |
        // d           |
        // e       #   |
        // f           |
        // g       #   |
        // h           |
        // i        # #|
        // j           |
        $this->assertSame(false, $this->getApiResponse('a1 a3 b5 b7 e7 g7 i8 i10')['is_valid']);
    }

    public function testBrokenShips() {
        //   1234567890
        // a           |
        // b           |
        // c   **      |
        // d   *       |
        // e     *     |
        // f           |
        // g           |
        // h           |
        // i           |
        // j           |
        $this->assertSame(false, $this->getApiResponse('c3c4d3e5')['is_valid']);
    }


    //
    // INTERNALS
    //

    const PIDFILE = '/tmp/battleship.pid';

    private static $apiBaseUrl = '';

    public static function setUpBeforeClass() {
        $apiUrlFromEnv = self::$apiBaseUrl = trim(getenv('BSAPI'), '/');
        if ($apiUrlFromEnv && !preg_match('#://#', $apiUrlFromEnv)) {
            $apiUrlFromEnv = 'http://' . $apiUrlFromEnv;
        }
        if ($apiUrlFromEnv) {
            self::$apiBaseUrl = $apiUrlFromEnv;
            fwrite(STDERR, "Using Battleship API server at {$apiUrlFromEnv}\n\n");
            return;
        }


        fwrite(STDERR, "Trying to start an API server...\n");
        $server = '127.0.0.1:32167';
        self::$apiBaseUrl = 'http://' . $server;

        self::removeDevServer();

        exec('php -S ' . $server . ' -t ' . __DIR__ . '/../www >/dev/null 2>&1 & echo $! >> ' . escapeshellarg(self::PIDFILE), $out, $err);
        // надо подождать немного, пока сервер инициализируется
        usleep(250000);
        fwrite(STDERR, "Started development server at " . self::$apiBaseUrl . "\n");
        fwrite(STDERR, "PID " . trim(file_get_contents(self::PIDFILE)) . "\n");

        $curl = curl_init(self::$apiBaseUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        if (curl_getinfo($curl)['http_code'] != 200) {
            fwrite(STDERR, "Error: development API server does not work.\n\n");
            exit(1);
        } else {
            fwrite(STDERR, "Development server is validated successfully.\n\n");
        }
    }

    public static function tearDownAfterClass() {
        self::removeDevServer();
    }

    private static function removeDevServer() {
        if (file_exists(self::PIDFILE)) {
            $pid = trim(file_get_contents(self::PIDFILE));
            if ($pid) {
                exec('kill ' . escapeshellarg($pid));
            }
            unlink(self::PIDFILE);
        }
    }

    private function getApiResponse($queryString) {
        $curl = curl_init(self::$apiBaseUrl . '/api/' . urlencode($queryString));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $body   = curl_exec($curl);
        $status = curl_getinfo($curl)['http_code'];

        $this->assertEquals(200, $status);
        $data = json_decode($body, true);
        $this->assertArrayHasKey('is_valid', $data);

        return $data;
    }
}
