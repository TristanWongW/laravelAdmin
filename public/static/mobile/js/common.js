function pege(src) {
    window.location.href = src;
}

function downFun() {
    $('body').css('position', 'fixed')
    $('.priceDow').removeClass('hidden');
    $(' .listBox').removeClass('hidden');
    $(' .listBox').animate({'right': '0'}, 600);
    var hei = window.innerHeight
    $('.listBox ul').css('height', hei - 90 + 'px')
}

function closeFun() {
    $('.priceDow').addClass('hidden');
    $('body').css('position', 'relative')
    $('  .listBox').animate({'right': '-100%'}, 490);
    setTimeout(function () {
        $(' .priceList .priceNav .listBox').addClass('hidden');
    }, 500)
}

function resetFun() {
    $('.listBox ul li').removeClass('active');
    $('.listBox ul li').children('img').remove();
}

function affirmFun() {
    closeFun();
    var json = [];
    var len = $('ul li').length;
    for (var i = 0; i < len + 1; i++) {
        var name = $('.listBox ul li:nth-child(' + (i + 1) + ')').attr('class');
        if (name == 'active') {
            json.push($('.listBox ul li:nth-child(' + (i + 1) + ') span').html());
        }
    }
    var html = ''
    for (var m = 0; m < json.length; m++) {
        html += json[0]
    }
    if (html == '') {
        $('.leiSpan').html('商品分类')
        $('.leiSpan').removeClass('active')
    } else {
        $('.leiSpan').html(html)
        $('.leiSpan').addClass('active')
    }

    return json;
}




