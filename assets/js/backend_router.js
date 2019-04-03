// backend_router.js

// Use the webpack feature allowing to read some variable: https://webpack.github.io/docs/shimming-modules.html
const { router, setRoutingData } = require('imports-loader?window=>{}!exports-loader?router=window.Routing,setData=fos.Router.setRoutingData!../../vendor/friensofsymfony/js-routing-bundle/Resources/public/js/router.js');
// dumped_routes.json is the output file for the fos:js-routing:dump command

const routes = require('../../public/js/fos_js_routes.json');

const routerConfig = routes;

setRoutingData(routerConfig);

modules.exports = router;