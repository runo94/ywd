<?php
/*
 Template Name: Home Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/

$args = array(
    'post_type' => array('custom_type', 'custom_post_type'),
    'post_status' => 'publish',
);
$new_post_loop = new WP_Query($args);
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="wrap cf">
        
        <main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
            <div class="wheels">
                <div class="controls">
                    <div class="btn active" id="afirmation">Afirmation</div>
                    <div class="btn" id="prediction">Prediction</div>
                </div>
                <div id="ywd_afirmations" class="active">
                    <div class="roulette">
                        <div class="wheel">
                            <button class="arrow spin" data-type="ywd_predictions">
                                <img src="<?php home_url() ?>/wp-content/uploads/2023/09/Asset-1.svg" />
                            </button>
                            <img class="wheel_img" src="<?php home_url() ?>wp-content/uploads/2023/09/wheel.svg">
                        </div>
                    </div>
                </div>
                <div id="ywd_predictions">
                    <div class="roulette">
                        <div class="wheel">
                            <button class="arrow spin" data-type="ywd_predictions">
                                <img src="<?php home_url() ?>/wp-content/uploads/2023/09/Asset-1.svg" />
                            </button>
                            <img class="wheel_img" src="<?php home_url() ?>wp-content/uploads/2023/09/wheel.svg">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            // if ($new_post_loop->have_posts()):
            //     while ($new_post_loop->have_posts()):
            //         $new_post_loop->the_post();
            // endwhile; endif; ?>

        </main>

    </div>

</div>

<div class="ywd_modal">
    <div class="ywd_modal_body"></div>
    <button class="btn">Close</button>
</div>


<div class="fireworks"></div>

<!-- jsDelivr  -->
<script src="https://cdn.jsdelivr.net/npm/fireworks-js@2.x/dist/index.umd.js"></script>

<!-- UNPKG -->
<script src="https://unpkg.com/fireworks-js@2.x/dist/index.umd.js"></script>

<script>

    const container = document.querySelector('.fireworks')
    const fireworks = new Fireworks.default(container, {
  autoresize: true,
  opacity: 0.5,
  acceleration: 1.05,
  friction: 0.97,
  gravity: 1.5,
  particles: 50,
  traceLength: 3,
  traceSpeed: 10,
  explosion: 5,
  intensity: 30,
  flickering: 50,
  lineStyle: 'round',
  hue: {
    min: 0,
    max: 360
  },
  delay: {
    min: 30,
    max: 60
  },
  rocketsPoint: {
    min: 50,
    max: 50
  },
  lineWidth: {
    explosion: {
      min: 1,
      max: 3
    },
    trace: {
      min: 1,
      max: 2
    }
  },
  brightness: {
    min: 50,
    max: 80
  },
  decay: {
    min: 0.015,
    max: 0.03
  },})
    
    jQuery(document).ready(function ($) {

        const getResult = (req_type) => {
            const afirmation = 'get_ajax_afirmations_posts';
            const prediction = 'get_ajax_predictions_posts';
            const req = req_type === 'ywd_afirmations' ? afirmation : prediction;
            console.log(req);
            return $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                dataType: "json", // add data type
                data: { action: req },
                success: (res) => {
                    $('.ywd_modal .ywd_modal_body').empty();
                    $('.ywd_modal .ywd_modal_body').append(`<p>${res.post_title}</p>`);
                    $('.ywd_modal').addClass('active');
                    $('.fireworks').addClass('active')
                    fireworks.start();
                }
            })
        };

        const result = async (req_type) => {
            const af = await getResult(req_type).then((res) => {
                return res
            })
        }

        perfecthalf = ((1 / 37) * 360) / 2;

        let currentLength = perfecthalf;

        const handleClick = () => {

        }

        $(".spin").click((event) => {
            const curr = event.currentTarget;

            console.log(curr.parentNode.parentNode.parentNode.id);
            $(`#${curr.parentNode.parentNode.parentNode.id} .${curr.parentNode.className} .wheel_img`).css("filter", "blur(8px)");
            $(".spin").addClass('disabled')

            spininterval = getRandomInt(0, 37) * (360 / 37) + getRandomInt(3, 4) * 360;
            currentLength += spininterval;

            numofsecs = spininterval;

            $(`#${curr.parentNode.parentNode.parentNode.id} .${curr.parentNode.className} .wheel_img`).css("transform", "rotate(" + currentLength + "deg)");

            setTimeout(function () {
                $(`#${curr.parentNode.parentNode.parentNode.id} .${curr.parentNode.className} .wheel_img`).css("filter", "blur(0px)");
            }, numofsecs);

            setTimeout(function () {
                $(".spin").removeClass('disabled')
                result(curr.parentNode.parentNode.parentNode.id)
            }, numofsecs + 8000);

        });

        $('.ywd_modal button').click(() => {
            $('.ywd_modal').removeClass('active')
            $('.fireworks').removeClass('active')
            fireworks.stop()
        })

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        $('.wheels .btn').click((event) => {
            const curr = event.currentTarget.id;
            $('.wheels .btn').removeClass('active');
            if (curr === 'afirmation') {
                $('#ywd_afirmations').addClass('active')
                $('#ywd_predictions').removeClass('active')
            }

            if (curr === 'prediction') {
                $('#ywd_predictions').addClass('active')
                $('#ywd_afirmations').removeClass('active')
            }
            $(`#${curr}`).addClass('active');
        })

    });
</script>

<?php get_footer(); ?>