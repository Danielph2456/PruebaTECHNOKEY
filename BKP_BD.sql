PGDMP  .                    {         	   technokey    16.1    16.0     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16396 	   technokey    DATABASE        CREATE DATABASE technokey WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Colombia.1252';
    DROP DATABASE technokey;
                postgres    false            �            1259    16409    usuarios    TABLE     �   CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    correo character varying(255) NOT NULL,
    contrasena character varying(255) NOT NULL,
    sesion integer
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �            1259    16408    usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.usuarios_id_seq;
       public          postgres    false    216            �           0    0    usuarios_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;
          public          postgres    false    215            �            1259    16420    vuelos    TABLE     R  CREATE TABLE public.vuelos (
    id integer NOT NULL,
    fecha_del_vuelo date NOT NULL,
    hora_de_salida time without time zone NOT NULL,
    hora_de_llegada time without time zone NOT NULL,
    duracion_del_trayecto interval NOT NULL,
    tipo_de_trayecto character varying(50) NOT NULL,
    costo_del_vuelo numeric(10,2) NOT NULL
);
    DROP TABLE public.vuelos;
       public         heap    postgres    false            �            1259    16419    vuelos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.vuelos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.vuelos_id_seq;
       public          postgres    false    218            �           0    0    vuelos_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.vuelos_id_seq OWNED BY public.vuelos.id;
          public          postgres    false    217            U           2604    16412    usuarios id    DEFAULT     j   ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);
 :   ALTER TABLE public.usuarios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    216    216            V           2604    16423 	   vuelos id    DEFAULT     f   ALTER TABLE ONLY public.vuelos ALTER COLUMN id SET DEFAULT nextval('public.vuelos_id_seq'::regclass);
 8   ALTER TABLE public.vuelos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    217    218    218            �          0    16409    usuarios 
   TABLE DATA           J   COPY public.usuarios (id, nombre, correo, contrasena, sesion) FROM stdin;
    public          postgres    false    216   q       �          0    16420    vuelos 
   TABLE DATA           �   COPY public.vuelos (id, fecha_del_vuelo, hora_de_salida, hora_de_llegada, duracion_del_trayecto, tipo_de_trayecto, costo_del_vuelo) FROM stdin;
    public          postgres    false    218   �       �           0    0    usuarios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuarios_id_seq', 2, true);
          public          postgres    false    215            �           0    0    vuelos_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.vuelos_id_seq', 23, true);
          public          postgres    false    217            X           2606    16418    usuarios usuarios_correo_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_key UNIQUE (correo);
 F   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_correo_key;
       public            postgres    false    216            Z           2606    16416    usuarios usuarios_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    216            \           2606    16425    vuelos vuelos_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.vuelos
    ADD CONSTRAINT vuelos_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.vuelos DROP CONSTRAINT vuelos_pkey;
       public            postgres    false    218            �   a   x�U�;
�0 �99�$���������U��_tsy�c�5-�k�oI��iO%G��!9_��@h~wN���$n�Rj�.�%�U������D�8�� �t )      �   m  x���MN�0F��]�l�n0N�f�X �AB�_8�S�B�ª�j��k�Px ��A=��� ������~��9L�x2��).7�/�	�-������ޱ�[I>�9l�ܢ�8�z/MÜ�w� %����>Eh��MߛR�bpqP�M���(�ոj���yeJb�n}%z�e}�QLvPJ�n��QE4Z�f�����+Z�����}� �ha⒳���N���Z�z9�GA�_ٶakq��_��f����=�{�W�8l-P\�J5��N���%��4%��q�).9�:4.w�D�,Q��b���h��zW��{�.����&�&*n����DVF�X�ˏ� }�6�� �     