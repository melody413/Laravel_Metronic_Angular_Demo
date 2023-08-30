import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BodypartListComponent } from './bodypart-list.component';

describe('BodypartListComponent', () => {
  let component: BodypartListComponent;
  let fixture: ComponentFixture<BodypartListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [BodypartListComponent]
    });
    fixture = TestBed.createComponent(BodypartListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
