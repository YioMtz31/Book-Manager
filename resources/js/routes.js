const Home = () => import("./components/MainComponent");
const Login = () => import("./components/Login");

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
    },
    {
        path: "/dashboard",
        component: Home,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
];

export default routes;
