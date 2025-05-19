<?php
namespace VisibleStacks\Commands;

use Illuminate\Console\Command;

class VisibleStacksCommand extends Command
{
    protected $signature = 'visible:stacks';
    protected $description = 'Count visible book stacks in a matrix';

    public function handle()
    {
        $this->info("📚 Book Stack Visibility Counter");

        $testMode = $this->choice('Run in test mode with hardcoded input?', ['y', 'n'], 1);
        if ($testMode === 'y') {
            $matrix = [
                [3, 1, 4],
                [1, 5, 9],
                [2, 6, 5],
            ];
            $n = count($matrix);
        } else {
            $n = (int) $this->ask('Enter N (1–50)');
            if ($n < 1 || $n > 50) {
                $this->error('N must be between 1 and 50');
                return 1;
            }
            $matrix = [];
            for ($i = 0; $i < $n; $i++) {
                while (true) {
                    $row = $this->ask("Row " . ($i + 1) . " of $n (enter $n integers between 0–1000, space-separated)");
                    $values = preg_split('/\s+/', trim($row));
                    if (count($values) === $n && array_reduce($values, fn($carry, $v) => $carry && is_numeric($v) && $v >= 0 && $v <= 1000, true)) {
                        $matrix[] = array_map('intval', $values);
                        break;
                    }
                    $this->error("You must enter exactly $n integers between 0 and 1000.");
                }
            }
        }

        $visibleCount = $this->countVisibleStacks($matrix);
        $this->info("Visible book stacks: $visibleCount");
        return 0;
    }

    private function countVisibleStacks(array $matrix): int
    {
        $n = count($matrix);
        $count = 0;

        for ($i = 0; $i < $n; $i++) {
            $maxLeft = -1;
            for ($j = 0; $j < $n; $j++) {
                if ($matrix[$i][$j] > $maxLeft) {
                    $count++;
                    $maxLeft = $matrix[$i][$j];
                }
            }
        }

        return $count;
    }
}
