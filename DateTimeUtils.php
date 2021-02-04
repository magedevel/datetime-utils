class DateTimeUtils
    /**
     * @param string $from
     * @param string $to
     * @param string $interval
     * @return array
     * @throws \Exception
     */
    public function getDateIntervals(string $from, string $to, string $interval = 'P1M'): array
    {
        $slides = [];
        $ret = [];

        $period = new \DatePeriod(
            new \DateTime($from),
            new \DateInterval($interval),
            new \DateTime($to)
        );

        foreach ($period as $key => $value) {
            $slides[] = $value->format('Y-m-d');

        }

        if (count($slides) <= 1) {
            $ret[] = ['from_date' => $from, 'to_date' => $to];
            return $ret;
        }

        foreach ($slides as $slide) {
            if ($slide === $from) {
                continue;
            }
            $ret[] = ['from_date' => $from, 'to_date' => $slide];
            $from = $slide;
        }

        if (strtotime(end($slides)) < strtotime($to)) {
            $ret[] = ['from_date' => end($slides), 'to_date' => $to];
        }

        return $ret;
    }
}
