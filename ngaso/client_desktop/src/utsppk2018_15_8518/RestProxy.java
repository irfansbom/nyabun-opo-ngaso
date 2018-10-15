package utsppk2018_15_8518;

import java.io.*;
import java.net.*;
import java.nio.charset.StandardCharsets;
import java.util.ArrayList;
import javax.xml.parsers.*;
import org.w3c.dom.*;
import org.xml.sax.SAXException;

public class RestProxy {

    private static RestProxy instance;
    private String host;

    private RestProxy() {
        host = "http://localhost/php_apache_folder/nyabun-opo-ngaso/ngaso/server/api";
    }

    public static synchronized RestProxy getInstance() {
        if (instance == null) {
            instance = new RestProxy();
        }

        return instance;
    }

    public Document getFromUri(String xmlUrl, String method, String urlParams) throws MalformedURLException, IOException, SAXException, ParserConfigurationException {
        URL url = new URL(host + xmlUrl);
        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
        boolean haveParams = true;

        if (urlParams.length() == 0) {
            haveParams = false;
        }

        byte[] postData = urlParams.getBytes(StandardCharsets.UTF_8);

        conn.setRequestMethod(method);
        conn.setUseCaches(false);

        if (haveParams) {
            conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
            conn.setDoOutput(true);
            conn.setRequestProperty("charset", "utf-8");
            conn.setRequestProperty("Content-Length", Integer.toString(postData.length));
            try (DataOutputStream dos = new DataOutputStream(conn.getOutputStream())) {
                dos.write(postData);

                dos.flush();
            }
        }

        InputStream is = conn.getInputStream();

        DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
        DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
        Document doc = dBuilder.parse(is);

        is.close();
        return doc;
    }

    public ArrayList<User> getAllUsers() throws Exception {
        ArrayList<User> userList = new ArrayList<>();
        Document res = getFromUri("/users.xml", "GET", "");
        NodeList users = res.getElementsByTagName("user");

        for (int i = 0; i < users.getLength(); i++) {
            Node nNode = users.item(i);
            if (nNode.getNodeType() == Node.ELEMENT_NODE) {
                Element eElement = (Element) nNode;
                User user = new User();

                user.setUsername(eElement.getElementsByTagName("username").item(0).getTextContent());
                user.setNamaLengkap(eElement.getElementsByTagName("nama_lengkap").item(0).getTextContent());
                user.setPassword(eElement.getElementsByTagName("password").item(0).getTextContent());
                user.setEmail(eElement.getElementsByTagName("email").item(0).getTextContent());

                userList.add(user);
            }
        }

        return userList;
    }

    public ArrayList<User> getUsersByQuery(String query) throws Exception {
        ArrayList<User> userList = new ArrayList<>();
        Document res = getFromUri("/users.xml?query=" + URLEncoder.encode(query, "UTF-8"), "GET", "");
        NodeList users = res.getElementsByTagName("user");

        for (int i = 0; i < users.getLength(); i++) {
            Node nNode = users.item(i);
            if (nNode.getNodeType() == Node.ELEMENT_NODE) {
                Element eElement = (Element) nNode;
                User user = new User();

                user.setUsername(eElement.getElementsByTagName("username").item(0).getTextContent());
                user.setNamaLengkap(eElement.getElementsByTagName("nama_lengkap").item(0).getTextContent());
                user.setPassword(eElement.getElementsByTagName("password").item(0).getTextContent());
                user.setEmail(eElement.getElementsByTagName("email").item(0).getTextContent());

                userList.add(user);
            }
        }

        return userList;
    }

    public int addUser(User user) throws Exception {
        Document res = getFromUri("/users.xml", "POST", user.toParamsString());
        String code = res.getElementsByTagName("status").item(0).getTextContent();
        return Integer.parseInt(code);
    }

    public int putUser(User user) throws Exception {
        Document res = getFromUri("/users.xml/" + URLEncoder.encode(user.getUsername(), "UTF-8"), "PUT", user.toParamsString());
        String code = res.getElementsByTagName("status").item(0).getTextContent();
        return Integer.parseInt(code);
    }
    
    public int deleteUser(String username) throws Exception {
        Document res = getFromUri("/users.xml/" + URLEncoder.encode(username, "UTF-8"), "DELETE", "");
        String code = res.getElementsByTagName("status").item(0).getTextContent();
        return Integer.parseInt(code);
    }
}
