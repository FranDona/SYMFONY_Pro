# Examen Ama Islantilla Resort
--------------

[//]: # (version: 1.0)
[//]: # (author: Fran Dona)
[//]: # (date: 2024-03-10)



## Tabla de contenidos
- [Examen Ama Islantilla Resort](#examen-ama-islantilla-resort)
  - [Tabla de contenidos](#tabla-de-contenidos)
  - [Indicaciones CRUD](#indicaciones-crud)
  - [Instrucciones de uso](#instrucciones-de-uso)



## Indicaciones CRUD

|   Entidades  |  C  |  R  |  U  |  D  |  Borrado Lógico  |
|:------------:|:---:|:---:|:---:|:---:|:----------------:|
| Habitaciones |  X  |  X  |  X  |  X  |                  |
| Reservas     |  X  |  X  |  X  |  X  |        X         |
| Clientes     |  X  |  X  |     |     |                  |

---

## Instrucciones de uso

1. Añadir clientes desde: http://localhost:8000/clientes/insertar
   
2. Añadir habitaciones desde: http://localhost:8000/habitaciones/insertar
   
3. Crear reservas a partir de los clientes y habitaciones en: http://localhost:8000/reservas/insertar
   
4. Ver listas en JSON
   - Habitaciones -> http://localhost:8000/habitaciones/consultarJSON
   - Reservas -> http://localhost:8000/reservas/consultarJSON
   - Clientes -> http://localhost:8000/clientes/consultarJSON

5. Visualizar listas en Twig
   - Habitaciones -> http://localhost:8000/habitaciones/consultar
   - Reservas -> http://localhost:8000/reservas/consultar
   - Clientes -> http://localhost:8000/clientes/consultar
  
6. Visualizar una consulta JOIN en Twig en: http://localhost:8000/consultaJOIN