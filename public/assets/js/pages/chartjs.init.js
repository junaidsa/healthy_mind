function getChartColorsArray(r) {
    if (null !== document.getElementById(r)) {
        var o = document.getElementById(r).getAttribute("data-colors");
        if (o)
            return (o = JSON.parse(o)).map(function (r) {
                var o = r.replace(" ", "");
                if (-1 === o.indexOf(",")) {
                    var e = getComputedStyle(
                        document.documentElement
                    ).getPropertyValue(o);
                    return e || o;
                }
                var t = r.split(",");
                return 2 != t.length
                    ? o
                    : "rgba(" +
                          getComputedStyle(
                              document.documentElement
                          ).getPropertyValue(t[0]) +
                          "," +
                          t[1] +
                          ")";
            });
    }
}
