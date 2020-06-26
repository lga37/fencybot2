/*----------------------------------------------------------------------------------------
 Classe GeoConversion

 Classe com funções utilitárias para conversão Lat/Long -> UTM e UTM -> Lat/Long.
----------------------------------------------------------------------------------------*/
class GeoConverson {

    static LatLng2UTM(lat, lng) {
        let latLng = new LatLon_Utm(lat, lng);

        return latLng.toUtm();
    }

    static UTM2LatLng(zone, hemisphere, easting, northing) {
        let utm = new Utm(zone, hemisphere, easting, northing);

        return utm.toLatLon();
    }
}

/*----------------------------------------------------------------------------------------
 Classe Point

 Representa um ponto (x, y) no plano cartesiano.
----------------------------------------------------------------------------------------*/
class Point {

    /**
    * Cria um ponto (x, y).
    *
    * @param {number} x - posição no eixo x.
    * @param {number} y - posição no eixo y.
    */
    constructor(x, y) {
        this.x = x;
        this.y = y;
    }

    /**
    * Calcula a distância euclidiana entre dois pontos.
    *
    * @param   {number} x1 - coordenada x do primeiro ponto.
    * @param   {number} y1 - coordenada y do primeiro ponto.
    * @param   {number} x2 - coordenada x do segundo ponto.
    * @param   {number} y2 - coordenada y do segundo ponto.
    * @returns {number} Distância euclidiana entre os pontos (x1, y1) e (x2, y2).
    */
    static distance(x1, y1, x2, y2) {
        return Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2));
    }

    /**
    * Retorna uma string com os dados do ponto.
    *
    * @param   {number} digits - número de casas decimais para os valores x e y.
    * @returns {string} String no formato "(999.99999999, 999.99999999)".
    */
    toString(digits = 8) {
        return `(${this.x.toFixed(digits)}, ${this.y.toFixed(digits)})`;
    }
}

/*----------------------------------------------------------------------------------------
 Classe GeoPoint

 Representa um ponto no mapa em coordenadas geográficas Lat/Long, convertendo essas
 coordenadas em UTM.

 Para que a conversão de Lat/Long para UTM seja realizada é IMPRESCINDÍVEL que o HTML
 contenha os seguintes scripts:

 <script src="./js/dms.js"></script>
 <script src="./js/vector3d.js"></script>
 <script src="./js/latlon-ellipsoidal.js"></script>
 <script src="./js/utm.js"></script>
----------------------------------------------------------------------------------------*/
class GeoPoint extends Point {

    /**
    * Cria um ponto em coordenadas Lat/Long e UTM.
    *
    * @param {number} lat - latitude em formato decimal.
    * @param {number} lng - longitude em formato decimal.
    */
    constructor(lat, lng) {

        super(0, 0);

        // Converte Lat/Long em UTM
        let utm = GeoConverson.LatLng2UTM(lat, lng);

        this.lat = lat;
        this.lng = lng;
        this.zone = utm.zone;
        this.hemisphere = utm.hemisphere;

        // Os valores (x, y) armazenam as coordenadas UTM easting e northing
        this.x = utm.easting;
        this.y = utm.northing;
    }

    /**
    * Converte um ponto em formato Lat/Long para coordenadas (x, y) da tela.
    *
    * @param   {Point} latLng - objeto da classe google.maps.LatLng.
    * @param   {Map} map - objecto da classe google.maps.Map.
    * @returns {Point} Coordenada (x, y) da tela em relação à area onde o mapa é apresentado .
    */
    static latLng2Point(latLng, map) {
        let topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
        let bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
        let scale = 1 << map.getZoom();
        let worldPoint = map.getProjection().fromLatLngToPoint(latLng);

        return new Point(
            Math.floor((worldPoint.x - bottomLeft.x) * scale),
            Math.floor((worldPoint.y - topRight.y) * scale));
    }

    /**
    * Retorna uma string com os dados do ponto.
    *
    * @param   {number} digits - número de casas decimais para as coordenadas Lat?Lng e UTM.
    * @returns {string} String no formato "Lat/Lng: 99.99999999 99.99999999  UTM: ZZ H 99999.99999999 99999.99999999".
    */
    toString(digits = 8) {
        return `Lat/Lng: ${this.lat.toFixed(digits)} ${this.lng.toFixed(digits)}
        UTM: ${this.zone.toString().padStart(2, '0')}
        ${this.hemisphere} ${this.x.toFixed(digits)} ${this.y.toFixed(digits)}`;
    }
}

/*----------------------------------------------------------------------------------------
 Classe Polygon

 Classe que representa um polígono (côncavo ou convexo) formado por coordenadas
 cartesianas
----------------------------------------------------------------------------------------*/
class Polygon {

    /**
    * Cria um polígono com zero vértices.
    */
    constructor() {
        // Vetor que armazena os vértices (x, y) do polígono
        this.vertex = [];
    }

    /**
    * Retorna o número de vértices do polígono.
    *
    * @returns {number} Número de vértices do polígono.
    */
    numberOfVertices() {
        return this.vertex.length;
    }

    /**
    * Retorna o vértice de um índice específica do vetor.
    *
    * @param   {number} index - índice do vetor.
    * @returns {Point}  Vértice que está no índice definido ou null, caso o índice seja inválida.
    */
    getVertex(index) {
        if (index >= 0 && index < this.vertex.length)
            return this.vertex[index];
        else
            return null;
    }

    /**
    * Busca um vértice do polígono que esteja a até determinada distância de um ponto.
    *
    * @param   {Point}  p - ponto.
    * @param   {number} dist - distância máxima do ponto p a um vértice do polígono.
    * @returns {number} Índice do vértice encontrado ou -1, se nenhum vértice foi encontrado.
    */
    findVertex(p, dist) {
        for (let i = 0; i < this.vertex.length; i++)
            // Calcula a distância euclidiana do ponto p ao vértice i
            if (Point.distance(p.x, p.y, this.vertex[i].x, this.vertex[i].y) <= dist)
                return i;

        return -1;
    }

    /**
    * Busca uma aresta do polígono que esteja próxima a um ponto.
    * A distância entre a aresta e o ponto é sempre medida na perpendicular.
    *
    * @param   {Point}  p - ponto.
    * @param   {number} dist - distância do ponto p a uma aresta do polígono.
    * @returns {Object} Índices dos vértices que formam a aresta e a distância da aresta ao ponto p, ou null se nenhuma aresta foi encontrada.
    */
    findEdge(p, dist) {
        for (let i = 0; i < this.vertex.length; i++) {
            // O último ponto do vetor deve se ligar ao primeiro para formar o polígono
            let next = i == this.vertex.length - 1 ? 0 : i + 1;

            // Cria uma área que circunscreve a aresta
            let b = new EdgeBounds(this.vertex[i].x, this.vertex[i].y, this.vertex[next].x, this.vertex[next].y, dist);

            // Para que um ponto pertença a uma aresta ele deve estar na área dessa aresta
            if (b.contains(p.x, p.y)) {
                // Calcula o ponto de interseção entre a aresta e o ponto p
                let point = this.intersectionEdgePoint(this.vertex[i], this.vertex[next], p.x, p.y);

                // Calcula a distância entre p e o ponto de interseção
                let d = Point.distance(p.x, p.y, point.x, point.y);

                if (d <= dist)
                    // Retorna os índices dos vértices que formam a aresta e a distância da aresta ao ponto p
                    return { start: i, end: next, distance: d };
            }
        }

        return null;
    }

    /**
    * Busca uma aresta do polígono que esteja próxima de um ponto e cria um novo vértice nessa aresta.
    *
    * @param   {Point}  p - ponto.
    * @param   {number} dist - distância do ponto p a uma aresta do polígono.
    * @returns {Object} Índice onde foi criado o novo vértice; ou -1, se não foi encontrada a aresta próxima.
    */
    createNewVertex(p, dist) {
        let edge = this.findEdge(p, dist);

        if (edge != null) {
            this.vertex.splice(edge.end, 0, p);
            return edge.end;
        }
        else
            return -1;
    }

    /**
    * Calcula o ponto de interseção entre uma reta e um ponto.
    *
    * @param   {Point}  p1 - ponto 1 que define a reta.
    * @param   {Point}  p2 - ponto 2 que define a reta.
    * @param   {number} x - cordenada x do ponto.
    * @param   {number} y - cordenada y do ponto.
    * @returns {Object} Índice onde foi criado o novo vértice; ou -1, se não foi encontrada a aresta próxima.
    */
    intersectionEdgePoint(p1, p2, x, y) {
        // Verifica se a linha está inclinada, na vertical ou horizontal
        if (p1.x != p2.x && p1.y != p2.y) {
            // Ponto de interseção para uma reta inclinada
            let coefS = (p2.y - p1.y) / (p2.x - p1.x);
            let coefT = -1 / coefS;
            let bS = p1.y - coefS * p1.x;
            let bT = y - coefT * x;
            let px = (bT - bS) / (coefS - coefT);
            let py = coefT * px + bT;

            return { x: px, y: py };
        }
        else if (p1.x != p2.x) // Ponto de interseção para uma reta na vertical
            return { x: p1.x, y: y };
        else                  // Ponto de interseção para uma reta na horizontal
            return { x: x, y: p1.y };
    }

    /**
    * Calcula o ponto de interseção entre duas arestas quaisquer do polígono.
    *
    * @returns {Point} Ponto de interseção entre duas arestas; ou nulo, caso não existam arestas que se cruzam.
    */
    intersectionEdge() {
        for (let i = 0; i < this.vertex.length - 2; i++) {
            for (let j = i + 2; j < this.vertex.length; j++) {
                let next = j + 1 == this.vertex.length ? 0 : j + 1;

                if (i == next)
                    break;

                let p = this.intersectionPoint(this.vertex[i], this.vertex[i + 1], this.vertex[j], this.vertex[next]);

                if (p != null)
                    return p;
            }
        }

        return null;
    }

    /**
    * Calcula o ponto de interseção entre dois segmentos de reta.
    *
    * @param   {Point} pa1 - ponto 1 do segmento de reta A.
    * @param   {Point} pa2 - ponto 2 do segmento de reta A.
    * @param   {Point} pb1 - ponto 1 do segmento de reta B.
    * @param   {Point} pb2 - ponto 2 do segmento de reta B.
    * @returns {Point} Ponto de interseção; ou nulo, caso não exista interseção.
    */
    intersectionPoint(pa1, pa2, pb1, pb2) {
        // Calcula o coeficiente angular das retas
        let coefA = (pa2.y - pa1.y) / (pa2.x - pa1.x);
        let coefB = (pb2.y - pb1.y) / (pb2.x - pb1.x);

        // Se as retas são paralelas então não tem interseção
        if (coefA == coefB)
            return null;

        let cA = pa1.y - coefA * pa1.x;
        let cB = pb1.y - coefB * pb1.x;
        let x = 0;
        let y = 0;

        if (coefA === Infinity) {
            // Segmento A está na vertical
            x = pa1.x;
            y = coefB * x + cB;
        }
        else if (coefB == Infinity) {
            // Segmento B está na vertical
            x = pb1.x;
            y = coefA * x + cA;
        }
        else {
            x = (cB - cA) / (coefA - coefB);
            y = coefA * x + cA;
        }

        // Calcula á area de cada segmento
        let b1 = new Bounds(pa1.x, pa1.y, pa2.x, pa2.y);
        let b2 = new Bounds(pb1.x, pb1.y, pb2.x, pb2.y);

        // A interseção deve estar nas áreas dos dois segmentos
        if (b1.contains(x, y) && b2.contains(x, y))
            return { x: x, y: y };
        else
            return null;
    }

    /**
    * Verifica se um ponto pertence a um polígono.
    *
    * Algoritmo adaptado de: https://wrf.ecse.rpi.edu/Research/Short_Notes/pnpoly.html
    *
    * @param  {Point}   p - ponto.
    * @return {boolean} Verdadeiro se o ponto pertence ao polígono; ou falso, caso contrário.
    */
    containsPoint(p) {
        let j = this.vertex.length - 1;
        let inside = false;

        for (let i = 0; i < this.vertex.length; i++) {
            if (((this.vertex[i].y > p.y) != (this.vertex[j].y > p.y)) && (p.x < (this.vertex[j].x - this.vertex[i].x) * (p.y - this.vertex[i].y) / (this.vertex[j].y - this.vertex[i].y) + this.vertex[i].x))
                inside = !inside;
            j = i;
        }

        return inside;
    }

    /**
    * Verifica se existe uma aresta próxima a um ponto.
    *
    * @param   {Point}  p - ponto.
    * @param   {number} dist - distância do ponto p a uma aresta do polígono.
    * @returns {Object} Distância da aresta; ou -1, se não foi encontrada a aresta próxima.
    */
    nearEdge(p, dist) {
        let edge = this.findEdge(p, dist);

        return edge != null ? edge.distance : -1;
    }

    /**
    * Calcula o ponto central" de um polígono, calculado como o ponto médio entre
    * as coordenadas X e Y mínimas e máximas.
    *
    * @return {Object} Ponto central; ou nulo, caso o polígono não tenha vértices.
    */
    centralPoint() {
        if (this.vertex.length == 0)
            return null;

        let minX = this.vertex[0].x;
        let maxX = this.vertex[0].x;
        let minY = this.vertex[0].y;
        let maxY = this.vertex[0].y;

        for (let i = 1; i < this.vertex.length; i++) {
            if (this.vertex[i].x < minX)
                minX = this.vertex[i].x;
            else if (this.vertex[i].x > maxX)
                maxX = this.vertex[i].x;

            if (this.vertex[i].y < minY)
                minY = this.vertex[i].y;
            else if (this.vertex[i].y > maxY)
                maxY = this.vertex[i].y;
        }

        return { x: minX + ((maxX - minX) / 2), y: minY + ((maxY - minY) / 2) };
    }

    /**
    * Insere um novo vértice no final do vetor de vértices.
    *
    * @param {Point} p - ponto.
    */
    addVertex(p) {
        this.vertex.push(p);
    }

    /**
    * Altera o vértice de uma posição do vetor de vértices.
    *
    * @param {number} index - índice do vetor.
    * @param {Point}  p - ponto.
    */
    setVertex(index, p) {
        this.vertex[index] = p;
    }

    /**
    * Deleta o vértice de uma posição do vetor de vértices.
    *
    * @param {number} index - índice do vetor.
    */
    deleteVertex(index) {
        this.vertex.splice(index, 1);
    }

    /**
    * Deleta todo o vetor de vértices
    */
    clear() {
        this.vertex = [];
    }
}

/*----------------------------------------------------------------------------------------
 Classe Bounds

 Classe que representa uma área retangular mínima que circuncreve uma figura geométrica.
----------------------------------------------------------------------------------------*/
class Bounds {

    /**
    * Cria uma área que circunscreve uma figura geométrica.
    *
    * @param {number} x1 - coordenada x do ponto 1 do segmento.
    * @param {number} y1 - coordenada y do ponto 1 do segmento.
    * @param {number} x2 - coordenada x do ponto 2 do segmento.
    * @param {number} y2 - coordenada x do ponto 2 do segmento.
    */
    constructor(x1, y1, x2, y2) {
        if (x2 < x1) {
            let temp = x1;
            x1 = x2;
            x2 = temp;
        }

        if (y2 < y1) {
            let temp = y1;
            y1 = y2;
            y2 = temp;
        }

        this.left = x1;
        this.top = y1;
        this.right = x2;
        this.bottom = y2;
    }

    /**
    * Verifica se um ponto (x, y) pertence à area
    *
    * @param {number} x - coordenada x do ponto p.
    * @param {number} y - coordenada y do ponto p.
    * @return {boolean} Verdadeiro se o ponto p pertence à área; ou falso, caso contrário.
    */
    contains(x, y) {
        return x >= this.left && x <= this.right && y >= this.top && y <= this.bottom;
    }
}

/*----------------------------------------------------------------------------------------
 Classe EdgeBounds

 Classe que representa uma área retangular mínima que circuncreve um segmento de reta.
----------------------------------------------------------------------------------------*/
class EdgeBounds extends Bounds {

    /**
    * Cria uma área que circunscreve um segmento de reta.
    *
    * @param {number} x1 - coordenada x do ponto 1 do segmento.
    * @param {number} y1 - coordenada y do ponto 1 do segmento.
    * @param {number} x2 - coordenada x do ponto 2 do segmento.
    * @param {number} y2 - coordenada x do ponto 2 do segmento.
    * @param {number} delta - valor a ser acrescido na largura ou altura da área.
    */
    constructor(x1, y1, x2, y2, delta) {
        super(x1, y1, x2, y2);

        // Calcula a tangente do segmento para saber a sua inclinação
        let coef = (y2 - y1) / (x2 - x1);

        // Dependendo da inclinação do segmento, o delta será aplicado no eixo X ou Y
        // Isso é feito porque para segmentos na vertical ou horizontal ou próximos disso,
        // a área que circunscreve o segmento fica muito estreita
        if (coef <= 1 && coef >= -1) {
            this.top -= delta;
            this.bottom += delta;
        }
        else {
            this.left -= delta;
            this.right += delta;
        }
    }
}

/*----------------------------------------------------------------------------------------
 Classe GMapFence

 Classe que representa uma cerca no objeto Map do Google Maps e onde os vértices são
 definidos em coordenadas geográficas Lat/Long e UTM.
----------------------------------------------------------------------------------------*/
class GMapFence extends Polygon {

    /**
    * Cria uma cerca com zero vértices.
    */
    constructor() {
        super();

        // Objeto que define uma Polyline no Google Maps
        // A cerca é renderizada como uma Polyline
        this.gmapPolyline = null;

        // Objeto que armazena os Markers do mapa
        // As arestas da cerca são representadas no mapa como Markers
        this.gmapMarkers = null;

        // Elementos usados para definir os labels de cada vértice
        this.labelIndex = 0;
        this.labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        // Código de erro relacionado ao formato do polígono
        // 0 - sem erro
        // 1 - polígono cobre mais de uma zona/hemisfério UTM
        // 2 - existem arestas que se cuzam
        this.erro = 0;
    }

    /**
    * Retorna a coordenada Lat/Long de um vértice específico da cerca.
    *
    * @param  {number} position - posição do vértice no vetor.
    * @return {GPoint} Coordenada Lat/Long do vértice específicado; ou nulo, se posição é inválida.
    */
    getLatLng(position) {
        if (position >= 0 && position < this.vertex.length)
            return { lat: this.vertex[position].lat, lng: this.vertex[position].lng };
        else
            return null;
    }

    /**
    * Verifica se a cerca possui um "caminho", ou seja, se tem dois ou mais vértices.
    *
    * @return {boolean} Verdadeiro se existe um caminho na cerca; ou falso, caso contrário.
    */
    hasPath() {
        return this.vertex.length > 1;
    }

    /**
    * Gera o "caminho" correspondente à cerca, ou seja, sua sequência de vértices.
    *
    * @return {Array} Vetor com as coordenadas Lat/Long que formam o "caminho" da cerca.
    */
    generatePath() {
        let path = [];

        for (let i = 0; i < this.vertex.length; i++)
            path.push(this.getLatLng(i));

        return path;
    }

    generateLatLngFence(){
        let fence = [];

        for (let i = 0; i < this.vertex.length; i++)
            fence.push(this.getLatLng(i));

        return fence;

    }

    /**
    * Retorna o ponto "central" da cerca em UTM.
    *
    * @return {Utm} Objeto com as coordenadas UTM.
    */
    centralPointUTM() {
        let p = this.centralPoint();

        if (p != null)
            p = new Utm(this.vertex[0].zona, this.vertex[0].hemisphere, p.x, p.y);

        return p;
    }

    /**
    * Retorna o ponto "central" da cerca em Lat/long.
    *
    * @return {LatLonEllipsoidal} Objeto com as coordenadas Lat/Long.
    */
    centralPointLatLng() {
        let p = this.centralPoint();

        if (p != null) {
            let utm = new Utm(this.vertex[0].zone, this.vertex[0].hemisphere, p.x, p.y);
            p = utm.toLatLon();
        }

        return p;
    }

    /**
    * Verifica se a cerca é válida:
    * - Verifica se a cerca abrange mais de uma zona UTM.
    * - Verifica se a cerca possui arestas que se cruzam.
    *
    * @return {boolean} Verdadeiro, se a cerca é válida; ou falso, caso contrário.
    */
    isValid() {

        // Cerca "vazia" é tratada como válida
        if (this.vertex.length == 0)
            return true;

        // Verifica se todos os vértices estão na mesma zona/hemisfério do primeiro vértice
        let z = this.vertex[0].zone;
        let h = this.vertex[0].hemisphere;

        for (let i = 1; i < this.vertex.length; i++)
            if (this.vertex[i].zone != z || this.vertex[i].hemisphere != h) {
                this.erro = GMapFence.MANY_ZONES;
                return false;
            }

        // Procura o ponto de interseção entre duas arestas quaisquer
        let p = this.intersectionEdge();

        if (p != null) {
            this.erro = GMapFence.BORDER_CROSS;
            return false;
        }

        return true;
    }

    /**
    * Renderiza a cerca
    *
    * @param {object} map - Objeto Map do Google Maps
    * @param {object} callbackDragEndMarker - função callback que trata o fim do arrasto de um Marker
    * @param {object} callBackContextMenu - função callback que trata o menu de contexto (botão da direita)
    * @param {object} callbackPolygon - função callback que trata o clique no Polyline
    */
    render(map, callbackDragEndMarker, callBackContextMenu, callbackPolygon) {
        // Limpa todos os objetos do mapa usados para renderizar a cerca
        this.clearFenceObjects();

        // Cria um Marker para cada vértice da cerca e associa esse Marker ao Map do Google Maps
        this.gmapMarkers = [];

        for (let i = 0; i < this.numberOfVertices(); i++) {
            let marker = new google.maps.Marker({
                position: this.getLatLng(i),
                draggable: true,
                label: this.labels[this.labelIndex++ % this.labels.length]
            });

            // Cria um atributo no Marker para recuperar posteriormente sua posição no vetor de vértices
            marker._index = i;

            google.maps.event.addListener(marker, 'dragend', callbackDragEndMarker);
            google.maps.event.addListener(marker, 'rightclick', callBackContextMenu);
            marker.setMap(map);
            this.gmapMarkers.push(marker);
        }

        // Se a cerca forma um caminho, então cria uma Polyline
        if (this.hasPath()) {
            this.gmapPolyline = new google.maps.Polygon({
                path: this.generatePath(),
                strokeColor: "#0000FF",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#0000FF",
                fillOpacity: 0.1
            });

            google.maps.event.addListener(this.gmapPolyline, 'click', callbackPolygon);
            this.gmapPolyline.setMap(map);
        }
    }

    /**
    * Limpa os objetos que representam a cerca no objeto Map, mais precisamente a Polyline e os Markers
    */
    clearFenceObjects() {

        this.labelIndex = 0;

        if (this.gmapPolyline != null) {
            google.maps.event.clearInstanceListeners(this.gmapPolyline);
            this.gmapPolyline.setMap(null);
            this.gmapPolyline = null;
        }

        if (this.gmapMarkers != null) {
            for (let p in this.gmapMarkers) {
                google.maps.event.clearInstanceListeners(this.gmapMarkers[p]);
                this.gmapMarkers[p].setMap(null);
                this.gmapMarkers[p] = null;
            }
            this.gmapMarkers = null;
        }
    }

    /**
    * Limpa toda a cerca:
    * - Os vértices que a compõem.
    * - Os objetos que representama cerca no Map.
    */
    clear() {
        super.clear();
        this.clearFenceObjects();
    }

    getPolyline(){
        return this.gmapPolyline;
    }

    /**
    * Retorna o código de erro gerado na última validação da cerca.
    *
    * @return {number} Código de erro
    */
    get errorCode() {
        return this.erro;
    }

    // Métodos utilitários para os códigos de erro
    static get MANY_ZONES() { return 1; }
    static get BORDER_CROSS() { return 2; }

}

/*----------------------------------------------------------------------------------------
 Classe ConteconstxMenu
 Classe que gerencia um menu de contexto.
----------------------------------------------------------------------------------------*/
class ContextMenu {

    /**
    * Cria o gerenciador do menu de contexto.
    *
    * @param {string} idMenu - id do menu de contexto no HTML.
    * @param {Array}  items - itens do menu de contexto, com suas respectivas id's e funções callback
    */
    constructor(idMenu, items) {
        this.idMenu = idMenu;
        this.targetObject = null;
        this.opened = false;

        // Associa cada item do menu ao seu tratador de evento "click"
        for (let i in items)
            $(items[i].id).on('click', items[i].callback);
    }


    open(x, y, target) {
        this.targetObject = target;
        this.opened = true;
        $(this.idMenu).css({
            display: "block",
            visibility: "visible",
            left: x,
            top: y
        });
    }

    close() {
        this.opened = false;
        $(this.idMenu).hide();
    }

    /**
    * @return {object} Objeto sobre o qual o menu foi aberto.
    */
    get target() {
        return this.targetObject;
    }

    /**
    * @return {boolean} Verdadeiro, se o menu de contexto está aberto; ou falso, caso contrário.
    */
    get isOpen() {
        return this.opened;
    }
}

/*----------------------------------------------------------------------------------------
 Classe ModalWindow

 Classe que gerencia uma janela modal do Boostrap.
----------------------------------------------------------------------------------------*/
class ModalWindow {

    /**
    * Cria o gerenciador da janela modal.
    *
    * @param {string} idModal - id da janela modal no HTML.
    * @param {string} idHeader - id do cabeçalho da janela modal.
    * @param {string} idText - id do texto da janela modal.
    */
    constructor(idModal, idHeader, idText) {
        this.idModal = idModal;
        this.idHeader = idHeader;
        this.idText = idText;
    }

    /**
    * Altera o cabeçalho da janela modal.
    *
    * @param {string} headerText - novo texto do cabeçalho da janela.
    */
    set header(headerText) {
        $(this.idHeader).text(headerText);
    }

    /**
    * Altera o texto da janela modal.
    *
    * @param {string} modalText - novo texto da janela.
    */
    set text(modalText) {
        $(this.idText).text(modalText);
    }

    /**
    * Altera o conteúdo da janela modal.
    *
    * @param {string} modalHtml - novo HTML da janela.
    */
    set html(modalHtml) {
        $(this.idText).html(modalHtml);
    }

    /**
    * Apresenta a janela modal.
    */
    show() {
        $(this.idModal).modal('show');
    }
}

/*----------------------------------------------------------------------------------------
 Variáveis "globais"
----------------------------------------------------------------------------------------*/

// Objeto que representa a cerca
var fence;

// Objeto mapa da API do Googgle Maps
var map;

// Booleano que indica o que deve ser processado quando o usuário interagir com o mapa:
// - Verdadeiro: verifica se um ponto pertence à cerca.
// - Falso: inclui um novo ponto na cerca.
var checkFence;

// Objeto que gerencia o menu de contexto
var ctxMenu;

// Objeto que gerencia uma janela modal de aviso
var modal;

/*--------------------------------------------------------------------------------------*/

/**
* Função que faz o setup inicial para criação/edição da cerca.
*/
function initApp() {
    //alert('aaa');
    // Coordenadas da cidade do Rio de Janeiro (usadas para centralizar inicialmente o mapa)
    // Isso deve ser alterado posteriormente para capturar a localização do usuário
    let lat = -22.90278;
    let lng = -43.2075;

    fence = new GMapFence();

    // Se já existe um conjunto de coordenadas de uma cerca, então adiciona esses
    // vértices à cerca para edição
    if (typeof coords !== "undefined" && coords != null)
        for (i in coords)
            fence.addVertex(new GeoPoint(coords[i].lat, coords[i].lng));

    // Se já existe um conjunto de coordenadas de uma cerca, então calcula a posição central
    // da cerca para posicionar o mapa nesse local
    if (fence.numberOfVertices() > 0) {
        let p = fence.centralPointLatLng();

        lat = p.lat;
        lng = p.lng;
    }

    // Cria o objeto que gerencia o menu de contexto
    // O menu deve ser criado no HTML usando bootstrap e id=context_menu
    ctxMenu = new ContextMenu("#context_menu",
        [{ id: '#delete_mark', callback: deleteMark },
        { id: '#center_mark', callback: centerMark },
        { id: '#close_menu', callback: closeContextMenu }]);

    // Cria o objeto que gerencia a janela modal
    // A janela deve ser criado no HTML usando bootstrap e id=janela_modal
    modal = new ModalWindow("#janela_modal", "#titulo_modal", "#texto_modal");

    // Define os tratadores de eventos do HTML
    $("input[name=opcao]").on("change", changeOption);
    $("#mostrar").on("click", showFenceCoords);
    $("#salvar").on("click", saveFence);
    $("#limpar").on("click", cleanFence);

    // Esconde o formulário de verificação da cerca
    $("#form2").hide();

    // Define as propriedades iniciais do mapa
    let mapProp = {
        center: new google.maps.LatLng(lat, lng),
        draggableCursor: 'crosshair',
        zoom: 15,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false

    }

    // Cria o objeto mapa
    map = new google.maps.Map(document.getElementById('mapa'), mapProp)

    // Adiciona o tratador do clique no mapa
    map.addListener('click', clickMap);

    // Desenha a cerca (caso já exista)
    drawFence();
}

/*--------------------------------------------------------------------------------------*/

/**
* Tratador do clique na Polyline.  No Google Maps, quando o usuário clica na região de
* uma Popyline, esse evento não é tratado como um clique no mapa e sim na polyline.
*/
function clickPolygon(ev) {
    // Caso o usuário clique no polígono, o evento é repassado para o tratador de clique
    // do mapa
    clickMap(ev);
}

/*--------------------------------------------------------------------------------------*/

/**
* Tratador do clique no mapa.
*/
function clickMap(ev) {

    // Ignora o clique no mapa quando o menu de contexto está aberto
    if (ctxMenu.isOpen)
        return;

    // Cria o ponto correspondente ao clique do usuário
    let p = new GeoPoint(ev.latLng.lat(), ev.latLng.lng());

    if (checkFence) {
        // Opção de verificação de pertinência cerca x ponto

        // Verifica se ponto p pertence à cerca
        if (fence.containsPoint(p)) {
            $("#inside").text("Dentro da cerca");

            let dist = parseInt($("#distance").val());

            if (isNaN(dist) || dist < 0)
                dist = 15;

            // Verifica se o ponto p está próximo de alguma borda da cerca
            // A distância dist é usada para definir o que significa "próximo"
            let d = fence.nearEdge(p, dist);

            $("#border_distance").text(d != -1 ? `${d.toFixed(1)}m` : `mais de ${dist}m`);
        } else {
            $("#inside").text("Fora da cerca");
            $("#border_distance").text("");
        }
    } else {
        // Opção de inclusão de novo ponto
        // Verifica se ponto p está próximo a alguma borda (o valor 5 indica o que significa "próximo")
        // Se o usuário clicou próximo a uma borda, então cria um novo vértice nesse ponto
        let position = fence.createNewVertex(p, 5);

        // Se ponto não está próximo a nenhuma borda, então acrescenta um novo ponto ao polígono
        if (position == -1)
            fence.addVertex(p);

        // Desenha a nova cerca
        drawFence();

        // Verifica se a cerca é válida após a inserção do novo ponto
        if (!fence.isValid()) {
            modal.header = "Erro!";
            modal.html = errorMsg();
            modal.show();
        }
    }
}

/*--------------------------------------------------------------------------------------*/

/**
* Tratador do evento do fim do arrasto de um Marker. Usado para mover um vértice da cerca.
*
* @param {object} ev - armazena as coordenadas geográficas (Lat/Long) do evento.
*/
function dragEndMark(ev) {
    // Recupera a posição do vértice movido (this é o objeto sobre o qual o evento ocorreu)
    let i = this._index;

    // Cria um novo ponto com as coordendas geográficas de onde o botão foi solto
    let p = new GeoPoint(ev.latLng.lat(), ev.latLng.lng());

    // Altera o vértice da posição i para as novas coordenadas
    fence.setVertex(i, p);

    // Redesenha e valida a cerca
    drawFence();

    if (!fence.isValid()) {
        modal.header = "Erro!";
        modal.html = errorMsg();
        modal.show();
    }
}

/*--------------------------------------------------------------------------------------*/

/**
* Tratador do evento de clique no botão direito. Usado para abrir o menu de contexto.
*/
function openContextMenu(ev) {
    // Converte o lat/lng do clique com botão direito em coordenadas (x, y) da tela
    // As coordenadas (x, y) são referentes à área (DIV) onde o mapa está sendo apresentado
    let p = GeoPoint.latLng2Point(ev.latLng, map);

    // Recupera a posição da DIV onde o mapa está sendo apresentado
    let mapPosition = $("#mapa").offset();

    // Abre o menu de contexto no local do marker clicado
    ctxMenu.open(p.x + mapPosition.left, p.y + mapPosition.top, this);
}

/*--------------------------------------------------------------------------------------*/

/**
* Fecha o menu de contexto.
*/
function closeContextMenu(ev) {
    ctxMenu.close();
}

/*--------------------------------------------------------------------------------------*/

/**
* Exclui um vértice da cerca.
*/
function deleteMark() {
    // O vértice a ser excluído é aquele onde o menu de contexto foi aberto.
    let marker = ctxMenu.target;

    ctxMenu.close();

    // Exclui o vértice da cerca
    // _index é a posição do vértice no vetor de vértices
    fence.deleteVertex(marker._index);

    // Redesenha e valida a cerca
    drawFence();

    if (!fence.isValid()) {
        modal.header = "Erro!";
        modal.html = errorMsg();
        modal.show();
    }
}

/*--------------------------------------------------------------------------------------*/

/**
* Centraliza o mapa na posição do vértice.
*
* @param {object} ev - armazena as coordenadas geográficas (Lat/Long) do evento.
*/
function centerMark(ev) {
    // Recupera o vértice onde o menu de contexto foi aberto
    let marker = ctxMenu.target;
    ctxMenu.close();

    // Centraliza o mapa nessa posição
    map.setCenter(marker.getPosition());
}

/*--------------------------------------------------------------------------------------*/

/**
* Renderiza a cerca no mapa.
*/
function drawFence() {
    $("#vertices").text(`${fence.numberOfVertices()} vértice(s)`);
    fence.render(map, dragEndMark, openContextMenu, clickPolygon);
}

/*--------------------------------------------------------------------------------------*/

/**
* Apresenta na janela modal as coordenadas dos vértices da cerca em Lat/Long e UTM.
*/
function showFenceCoords() {
    let s = "<textarea rows='10' cols='60'>";

    for (let i = 0; i < fence.numberOfVertices(); i++)
        s += fence.getVertex(i).toString() + "\n";

    modal.header = "Coordenadas da cerca";
    modal.html = s + "</textarea>";
    modal.show();
}

/*--------------------------------------------------------------------------------------*/
function fence2LatLng(fence){
    var latlng = [];
    var len = fence.length;

    for(var i=0; i<len; i++){
        latlng.push({lat: fence[i].lat, lng: fence[i].lng });
    }
    return latlng;
}


/**
* Simula a operação de "salvar" a cerca, ou seja, simula o SUBMIT das coordenadas da cerca
* para o servidor.
*/
function saveFence() {

    if (fence.numberOfVertices() == 0) {
        modal.header = "Error!";
        modal.html = "Fence not defined";
        modal.show();

    } else if (fence.isValid()) {

        var user_id = document.getElementById('user_id').value;
        var nome_cerca = document.getElementById('nome_cerca').value;

        var fenceLatLng = fence2LatLng(fence.vertex);

        var data = JSON.stringify({user_id:user_id,name:nome_cerca,fence:fenceLatLng});
        console.log(data);

        var url;
        if (location.hostname === "localhost" || location.hostname === "127.0.0.1")
            url = "http://localhost/fencybot/public/adm/fence/add";
        else
            url = "http://200.156.26.136/fencybot/public/adm/fence/add";

        $.ajax({

            url: url,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            data: data,
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Cache-Control': 'no-store, no-cache, must-revalidate, max-age=0',
                'Cache-Control': 'post-check=0, pre-check=0, false',
                'Pragma': 'no-cache'

            },
            dataType: 'json',
            success: function (d) {
                alert('Fence registered with Success!');
                location.reload();
            },
            error: function (e) {
                alert('Error: '+JSON.stringify(e));
            }
        });
        document.getElementById('nome_cerca').value="";
        cleanFence();

    } else {
        modal.header = "Erro!";
        modal.html = errorMsg();
        modal.show();
    }

}

/*--------------------------------------------------------------------------------------*/

/**
* Retorna a mensagem de erro correspondente à última validação da cerca.
*
* @return {string} Mensagem de erro.
*/
function errorMsg() {
    if (fence.errorCode == GMapFence.MANY_ZONES)
        return "As coordenadas da cerca pertencem a mais de uma zona UTM.<br>A cerca deve estar totalmente dentro de uma única zona UTM.";
    else
        return "A cerca possui bordas que se cruzam.<br>Esse formato é inválido.";;
}

/*--------------------------------------------------------------------------------------*/

/**
* Apaga toda a cerca desenhada até agora.
*/
function cleanFence() {
    fence.clear();
    resetFormFields();
}

/*--------------------------------------------------------------------------------------*/

/**
* Altera o formulário visualizado pelo usuário.
*/
function changeOption(ev) {
    resetFormFields();

    if (ev.target.value == "1") {
        $("#form2").hide();
        $("#form1").show();
        checkFence = false;
    } else {
        $("#form1").hide();
        $("#form2").show();
        checkFence = true;
    }
}

/*--------------------------------------------------------------------------------------*/

/**
* Limpa os campos do formulário para os dados padrão.
*/
function resetFormFields() {
    $("#vertices").text(`${fence.numberOfVertices()} vértice(s)`);
    $("#distance").text("15");
    $("#inside").text("");
    $("#border_distance").text("");
}
