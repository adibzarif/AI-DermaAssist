<?php
function timeSince(string $ts): string {
    if (empty($ts)) return 'recently';
    $diff = time() - strtotime($ts);
    if ($diff < 3600)  return round($diff / 60)  . 'm ago';
    if ($diff < 86400) return round($diff / 3600) . 'h ago';
    return round($diff / 86400) . 'd ago';
}
