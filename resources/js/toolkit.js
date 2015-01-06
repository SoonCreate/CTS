/** 数字金额大写转换(可以处理整数,小数,负数) */
digitUppercase = function(n) {
    var fraction = ['角', '分'];
    var digit = [
        '零', '壹', '贰', '叁', '肆',
        '伍', '陆', '柒', '捌', '玖'
    ];
    var unit = [
        ['元', '万', '亿'],
        ['', '拾', '佰', '仟']
    ];
    var head = n < 0 ? '欠' : '';
    n = Math.abs(n);
    var s = '';
    for (var i = 0; i < fraction.length; i++) {
        s += (digit[Math.floor(n * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');
    }
    s = s || '整';
    n = Math.floor(n);
    for (var i = 0; i < unit[0].length && n > 0; i++) {
        var p = '';
        for (var j = 0; j < unit[1].length && n > 0; j++) {
            p = digit[n % 10] + unit[1][j] + p;
            n = Math.floor(n / 10);
        }
        s = p.replace(/(零.)*零$/, '').replace(/^$/, '零') + unit[0][i] + s;
    }
    return head + s.replace(/(零.)*零元/, '元')
            .replace(/(零.)+/g, '零')
            .replace(/^整$/, '零元整');
};

/**
 * 将所有 s 的属性复制给 r
 * @param r {Object}
 * @param s {Object}
 * @param is_overwrite {Boolean} 如指定为 false ，则不覆盖已有的值，其它值
 *	  包括 undefined ，都表示 s 中的同名属性将覆盖 r 中的值
 */
function mix(r, s, is_overwrite) {
    if (!s || !r) return r;

    for (var p in s) {
        if (is_overwrite !== false || !(p in r)) {
            r[p] = s[p];
        }
    }
    return r;
}