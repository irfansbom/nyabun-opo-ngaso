package utsppk2018_15_8518;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class User {

    private String username;
    private String email;
    private String namaLengkap;
    private String password;

    public String getUsername() {
        return username;
    }
public void setUsername(String username) throws Exception {
        if (username.length() < 4) {
            throw new Exception("username minimal 4 huruf");
        }
        this.username = username;
    }

    public String getNamaLengkap() {
        return namaLengkap;
    }

    public void setNamaLengkap(String namaLengkap) throws Exception {
        if (username.length() == 0) {
            throw new Exception("nama harus diisi");
        }
        this.namaLengkap = namaLengkap;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) throws Exception {
        int num = 0;
        int ch = 0;
        for (int i = 0; i < password.length(); i++) {
            if(Character.isDigit(password.charAt(i))){
                num++;
            }
            if(Character.isLetter(password.charAt(i))){
                ch++;
            }
        }
        if (num == 0 || ch == 0) {
            throw new Exception("password harus terdiri dari angka dan huruf");
        }
        this.password = password;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) throws Exception {
        boolean goodAt = false;
        for (int i = 0; i < email.length(); i++) {
            if (email.charAt(i) == '@'){
                goodAt = true;
            }
        }
        if (!goodAt) {
            throw new Exception("format email salah");
        }
        this.email = email;
    }

    @Override
    public String toString() {
        return "Username    : " + username + "\n"
                + "Nama Lengkap: " + namaLengkap + "\n"
                + "Password    : " + password + "\n"
                + "Email       : " + email + "\n\n";
    }

    public String toParamsString() {
        try {
            return "username=" + URLEncoder.encode(username, "UTF-8")
                    + "&nama_lengkap=" + URLEncoder.encode(namaLengkap, "UTF-8")
                    + "&password=" + URLEncoder.encode(password, "UTF-8")
                    + "&email=" + URLEncoder.encode(email, "UTF-8");
        } catch (UnsupportedEncodingException ex) {
            System.out.println("UTF-8 fault");
            return "";
        }
    }

}
