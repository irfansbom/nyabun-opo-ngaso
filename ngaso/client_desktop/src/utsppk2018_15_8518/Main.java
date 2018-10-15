/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utsppk2018_15_8518;


/**
 *
 * @author 15.8518
 */
public class Main {

    public static void main(String args[]) {
        MainFrame mf = new MainFrame();
        RestProxy proxy = RestProxy.getInstance();
        
        GUIController gc = new GUIController(mf, proxy);
        

        
        java.awt.EventQueue.invokeLater(() -> {
            mf.setVisible(true);
        });
    }
}
