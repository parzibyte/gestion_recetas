import Vue from 'vue'
import Router from 'vue-router'
import NuevaReceta from '@/components/NuevaReceta'
import Recetas from '@/components/Recetas'
import Recetario from '@/components/Recetario'
import EditarReceta from '@/components/EditarReceta'
import DetalleReceta from '@/components/DetalleReceta'
import AcercaDe from '@/components/AcercaDe'

Vue.use(Router);

export default new Router({
    routes: [{
        path: '/nueva-receta',
        name: 'NuevaReceta',
        component: NuevaReceta
    },
    {
        path: '/recetas',
        name: 'Recetas',
        component: Recetas,
    },
    {
        path: '/',
        name: 'Recetario',
        component: Recetario,
    },
    {
        path: '/receta/editar/:id',
        name: 'EditarReceta',
        component: EditarReceta,
    },
    {
        path: '/receta/:id',
        name: 'DetalleReceta',
        component: DetalleReceta,
    },
    {
        path: '/acerca-de',
        name: 'AcercaDe',
        component: AcercaDe,
    },
    ]
});